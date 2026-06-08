<?php

namespace App\Livewire\TradeMeeting;

use App\Enums\ProductStatus;
use App\Enums\TransactionStatus;
use App\Models\TradeMeeting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class Seller extends DataTableComponent
{
    public $agenda, $duration, $password, $start_time, $end_time, $transaction_select;
    protected $model = TradeMeeting::class;

    public function handleCreation()
    {
        $this->validate([
            'agenda' => 'required',
            'duration' => 'required|numeric|min:30',
            'password' => 'required',
            'start_time' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (Carbon::parse($value, 'Asia/Jakarta')->isPast()) {
                        $fail('Waktu mulai harus di masa depan.');
                    }
                },
            ],
            'end_time' => 'required|date',
            'transaction_select' => 'required|exists:transactions,id',
        ]);

        if (Carbon::parse($this->end_time)->lessThanOrEqualTo(Carbon::parse($this->start_time))) {
            $this->addError('end_time', 'Waktu selesai harus lebih besar dari waktu mulai.');
            return;
        }

        try {
            $response = \Jubaer\Zoom\Facades\Zoom::createMeeting([
                'topic' => $this->agenda,
                'type' => 2,
                'start_time' => Carbon::parse($this->start_time, 'Asia/Jakarta')->toIso8601String(),
                'duration' => $this->duration,
                'timezone' => 'Asia/Jakarta',
                'password' => $this->password,
                'end_time' => Carbon::parse($this->end_time, 'Asia/Jakarta')->toIso8601String(),
                'settings' => [
                    'join_before_host' => true,
                    'waiting_room' => false,
                ]
            ]);

            if (!isset($response['data']) || !is_array($response['data'])) {
                Log::error($response);
                throw new \RuntimeException('Invalid response from Zoom API.');
            }

            $zoom = $response['data'];
        } catch (\Throwable $e) {
            Log::error('Zoom meeting creation failed', ['message' => $e->getMessage()]);
            $this->addError('zoom', 'Gagal membuat meeting Zoom. Silakan coba lagi nanti.');
            return $this->dispatch('toast', message: 'Gagal Membuat Meeting', data: ['position' => 'top-right', 'type' => 'danger']);
        }

        TradeMeeting::create([
            'zoom_id' => $zoom['id'],
            'seller_id' => auth()->user()->seller->id,
            'buyer_id' => Transaction::find($this->transaction_select)->buyer->id,
            'password' => $this->password,
            'topic' => $this->agenda,
            'start_time' => Carbon::parse($zoom['start_time'])->format('Y-m-d H:i:s'),
            'duration' => $zoom['duration'],
        ]);

        $this->dispatch('close-modal', 'create');
        $this->dispatch('refreshDataTable');
        return $this->dispatch('toast', message: 'Berhasil Membuat Meeting', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function builder(): Builder
    {
        return TradeMeeting::query()
            ->where('seller_id', auth()->user()->seller->id)
            ->orderBy('created_at', 'desc');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setConfigurableArea('toolbar-right-start', [
            'components.table.seller-meeting-action',
            [
                'transaction' => Transaction::where('seller_id', auth()->user()->seller->id)
                    ->where('status', TransactionStatus::DONE)
                    ->with(['buyer'])
                    ->get(),
            ]
        ]);
    }

    public function openCreateModal()
{
    $transactions = Transaction::where('seller_id', auth()->user()->seller->id)
        ->where('status', TransactionStatus::DONE)
        ->get();
    
    if ($transactions->count() === 1) {
        $this->transaction_select = $transactions->first()->id;
    }
    
    $this->dispatch('open-modal', 'create');
}

    public function columns(): array
    {
        return [

            IncrementColumn::make('#'),

            Column::make('Agenda', 'topic')
                ->sortable()
                ->searchable(),
            Column::make('Password', 'password'),
            Column::make('Start Time', 'start_time')
                ->sortable()
                ->format(function ($value) {
                    return Carbon::parse($value, 'UTC')->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y H:i') . ' WIB';
                }),
            Column::make('Duration', 'duration')
                ->format(function ($value) {
                    return $value . ' menit';
                }),
            Column::make('Status', 'status')
                ->format(
                    fn($value, $row, Column $column) => view('components.table.product-table-badge', [
                        'status' => $value,
                    ])
                )
                ->sortable(),
            Column::make('Actions', 'zoom_id')
                ->format(
                    function ($value, $row, Column $column) {
                        $zoom_meeting_url = '';
                        $isExpired = false;

                        // Cek apakah meeting sudah expired
                        $meetingEnd = Carbon::parse($row->start_time)->addMinutes((int) $row->duration);
                        $isExpired = Carbon::now('Asia/Jakarta')->greaterThan($meetingEnd);

                        if ($row->status === ProductStatus::APPROVED && !$isExpired) {
                            try {
                                $zoom_meeting_data = \Jubaer\Zoom\Facades\Zoom::getMeeting($row->zoom_id);
                                $zoom_meeting_url = $zoom_meeting_data['data']['join_url'] ?? '';
                            } catch (\Throwable $e) {
                                Log::error('Failed to fetch Zoom meeting.', [
                                    'zoom_id' => $row->zoom_id,
                                    'exception' => get_class($e),
                                    'message' => $e->getMessage(),
                                ]);
                            }
                        }

                        return view('components.table.seller-meeting-table-action', [
                            'zoom_meeting_id' => $zoom_meeting_url,
                            'status' => $row->status,
                            'is_expired' => $isExpired,
                        ]);
                    }
                ),

        ];
    }
}
