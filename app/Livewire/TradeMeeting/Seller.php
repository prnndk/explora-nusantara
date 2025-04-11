<?php

namespace App\Livewire\TradeMeeting;

use App\Models\TradeMeeting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class Seller extends DataTableComponent
{
    public $agenda, $duration, $password, $start_time, $end_time;
    protected $model = TradeMeeting::class;

    public function handleCreation()
    {
        $this->validate([
            'agenda' => 'required',
            'duration' => 'required',
            'password' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
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
            'buyer_id' => \App\Models\Buyer::orderBy('id', 'desc')->first()->id,
            'password' => $this->password,
            'topic' => $this->agenda,
            'start_time' => $zoom['start_time'],
            'duration' => $zoom['duration'],
        ]);

        $this->dispatch('toast', message: 'Berhasil Membuat Meeting', data: ['position' => 'top-right', 'type' => 'success']);
        $this->dispatch('close-modal', 'create');
        $this->dispatch('refreshDataTable');
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
        $this->setConfigurableArea('toolbar-right-start', 'components.table.seller-meeting-action');
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
                            'zoom_meeting_id' => $zoom_meeting_id,
                        ]);
                    }
                ),

        ];
    }
}
