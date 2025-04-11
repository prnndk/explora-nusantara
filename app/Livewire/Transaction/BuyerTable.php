<?php

namespace App\Livewire\Transaction;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class BuyerTable extends DataTableComponent
{
    protected $model = Transaction::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Transaction::query()
            ->where('buyer_id', auth()->user()->buyer->id)
            ->with([
                'product',
                'seller'
            ])
            ->orderBy('transactions.created_at', 'desc');
    }

    public function cancelTransaction($id)
    {
        $transaction = Transaction::where('id', $id)
            ->firstOrFail();
        try {

            if ($transaction) {
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
            Column::make("Product", "product.nama")
                ->searchable()
                ->sortable(),
            Column::make("Duration")
                ->label(function () {
                    return '10 Hari';
                })
                ->sortable(),
            Column::make("Supplier", "seller.company_name"),

            Column::make("status", "status")
                ->format(
                    fn($value, $row, Column $column) => view('components.table.transaction-badge', [
                        'status' => $value,
                    ])
                )
                ->sortable(),
            Column::make("Actions", 'id')->format(
                fn($value, $row, Column $column) => view('components.table.transaction.buyer-action', [
                    'id' => $value,
                ])
            )
        ];
    }
}
