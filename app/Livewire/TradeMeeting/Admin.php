<?php

namespace App\Livewire\TradeMeeting;

use App\Enums\ProductStatus;
use App\Models\TradeMeeting;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class Admin extends DataTableComponent
{
    protected $model = TradeMeeting::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function approveMeeting($id)
    {
        $meeting = TradeMeeting::where('zoom_id', $id)->firstOrFail();

        $meeting->status = ProductStatus::APPROVED;

        $meeting->save();

        $this->dispatch('refreshDataTable');
        $this->dispatch('close-modal', 'confirm-action-' . $id);
        $this->dispatch('toast', message: 'Berhasil merubah status', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function cancelMeeting($id)
    {
        $meeting = TradeMeeting::where('zoom_id', $id)->firstOrFail();

        $meeting->status = ProductStatus::REJECTED;

        $meeting->save();

        $this->dispatch('refreshDataTable');
        $this->dispatch('close-modal', 'confirm-action-' . $id);
        $this->dispatch('toast', message: 'Berhasil merubah status', data: ['position' => 'top-right', 'type' => 'success']);
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
                        $zoom_meeting_url = '';

                        try {
                            $response = \Jubaer\Zoom\Facades\Zoom::getMeeting($row->zoom_id);

                            if (is_array($response)) {
                                $data = $response['data'] ?? $response;
                                $zoom_meeting_url = $data['start_url'] ?? $data['join_url'] ?? '';
                            } elseif (is_object($response)) {
                                $data = $response->data ?? $response;
                                $zoom_meeting_url = $data->start_url ?? $data->join_url ?? '';
                            }
                        } catch (\Throwable $e) {
                            \Illuminate\Support\Facades\Log::error('Failed to fetch Zoom meeting.', [
                                'zoom_id' => $row->zoom_id,
                                'exception' => get_class($e),
                                'message' => $e->getMessage(),
                            ]);
                        }

                        return view('components.table.admin-meeting-action', [
                            'zoom_meeting_id' => $zoom_meeting_url,
                            'id' => $value,
                        ]);
                    }
                ),

        ];
    }
}
