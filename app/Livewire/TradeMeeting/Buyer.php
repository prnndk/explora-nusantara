<?php

namespace App\Livewire\TradeMeeting;

use App\Enums\ProductStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\TradeMeeting;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class Buyer extends DataTableComponent
{
    protected $model = TradeMeeting::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return TradeMeeting::query()
            ->where('buyer_id', auth()->user()->buyer->id)
            ->orderBy('created_at', 'desc');
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