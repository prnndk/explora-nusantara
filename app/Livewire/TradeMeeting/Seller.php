<?php

namespace App\Livewire\TradeMeeting;

use App\Enums\ProductStatus;
use App\Enums\TransactionStatus;
use App\Models\TradeMeeting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'transaction_select' => 'required|exists:transactions,id',
        ]);

        $zoom = \Jubaer\Zoom\Facades\Zoom::createMeeting([
            'topic' => $this->agenda,
            'type' => 2,
            'start_time' => Carbon::parse($this->start_time)->setTimezone('Asia/Jakarta')->toIso8601String(),
            'duration' => $this->duration,
            'timezone' => 'Asia/Jakarta',
            'password' => $this->password,
            'end_time' => Carbon::parse($this->end_time)->setTimezone('Asia/Jakarta')->toIso8601String(),
        ]);

        $zoom = $zoom['data'];

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
                'transaction' => Transaction::where('seller_id', auth()->user()->seller->id)->where('status', TransactionStatus::DONE)->with(['buyer'])->get(),
            ]
        ]);
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
                    return Carbon::parse($value)->locale('id')->translatedFormat('l, d F Y H:i');
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
                        $zoom_meeting_data = \Jubaer\Zoom\Facades\Zoom::getMeeting($row->zoom_id);
                        $zoom_meeting_url = isset($zoom_meeting_data['data']) && isset($zoom_meeting_data['data']['join_url'])
                            ? $zoom_meeting_data['data']['join_url']
                            : '';
                        return view('components.table.seller-meeting-table-action', [
                            'zoom_meeting_id' => $row->status === ProductStatus::REJECTED ? '' : $zoom_meeting_url,
                        ]);
                    }
                ),

        ];
    }
}
