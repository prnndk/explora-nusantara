<?php

namespace App\Livewire\TradeMeeting;

use App\Enums\ProductStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
            ->whereIn('status', [ProductStatus::APPROVED, ProductStatus::REJECTED])
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
                        $zoom_meeting_id = \Jubaer\Zoom\Facades\Zoom::getMeeting($row->zoom_id);
                        $zoom_meeting_id = $zoom_meeting_id['data']['join_url'];
                        return view('components.table.seller-meeting-table-action', [
                            'zoom_meeting_id' => $row->status === ProductStatus::REJECTED ? '' :$zoom_meeting_id,
                        ]);
                    }
                ),

        ];
    }
}
