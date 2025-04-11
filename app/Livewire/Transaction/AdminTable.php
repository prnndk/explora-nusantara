<?php

namespace App\Livewire\Transaction;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Transaction;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class AdminTable extends DataTableComponent
{
    protected $model = Transaction::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
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

    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),
            Column::make("Product", "product.nama")
                ->searchable()
                ->sortable(),
            Column::make("Contract")
                ->label(function () {
                    return '#AD123328';
                })
                ->sortable(),
            Column::make("Buyer", "buyer.company_name"),
            Column::make("Supplier", "seller.company_name"),

            Column::make("status", "status")
                ->format(
                    fn($value, $row, Column $column) => view('components.table.transaction-badge', [
                        'status' => $value,
                    ])
                )
                ->sortable(),
            Column::make("Actions", 'id')->format(
                fn($value, $row, Column $column) => view('components.table.transaction.admin-action', [
                    'id' => $value,
                ])
            )
        ];
    }
}
