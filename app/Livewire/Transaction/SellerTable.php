<?php

namespace App\Livewire\Transaction;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class SellerTable extends DataTableComponent
{
    protected $model = Transaction::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Transaction::query()
            ->where('transactions.seller_id', auth()->user()->seller->id)
            ->with([
                'product',
                'chat' => function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->where('sender_id', '!=', auth()->id());
                    })->where('read_status', false)->count();
                },
                'buyer',
            ])
            ->withCount('chat')
            ->orderBy('transactions.created_at', 'desc');
    }

    public function approveTransaction($id)
    {
        $transaction = Transaction::where('id', $id)
            ->firstOrFail();
        try {

            if ($transaction) {
                $transaction->update([
                    'status' => TransactionStatus::DONE
                ]);
            }
        } catch (\Exception $exception) {
            $this->dispatch('toast', message: 'Gagal mengupdate status', data: ['position' => 'top-center', 'type' => 'error']);
            return;
        }
        $this->dispatch('toast', message: 'Berhasil mengupdate status', data: ['position' => 'top-center', 'type' => 'success']);
        $this->dispatch('refreshDataTable');
    }

    public function cancelTransaction($id)
    {
        $transaction = Transaction::where('id', $id)
            ->firstOrFail();
        try {

            if ($transaction) {
                if ($transaction->status === TransactionStatus::DONE) {
                    $this->dispatch('toast', message: 'Gagal update, status sudah selesai', data: ['position' => 'top-center', 'type' => 'danger']);

                    return;
                }
                $transaction->update([
                    'status' => TransactionStatus::CANCELED
                ]);
            }
        } catch (\Exception $exception) {
            $this->dispatch('toast', message: 'Gagal mengupdate status', data: ['position' => 'top-center', 'type' => 'error']);
            return;
        }
        $this->dispatch('toast', message: 'Berhasil mengupdate status', data: ['position' => 'top-center', 'type' => 'success']);
        $this->dispatch('refreshDataTable');
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),
            Column::make("Product", "product.name")
                ->label(fn($row, Column $column) => view('components.table.transaction.name-with-chat-count')->withRow($row))
                ->sortable()
                ->searchable(),
            Column::make("Duration")
                ->label(function () {
                    return '10 Hari';
                })
                ->sortable(),
            Column::make("Buyer", "buyer.name"),

            Column::make("status", "status")
                ->format(
                    fn($value, $row, Column $column) => view('components.table.transaction-badge', [
                        'status' => $value,
                    ])
                )
                ->sortable(),
            Column::make("Actions", 'id')->format(
                fn($value, $row, Column $column) => view('components.table.transaction.seller-action', [
                    'id' => $value,
                ])
            )
        ];
    }
}
