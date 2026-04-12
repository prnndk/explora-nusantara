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
        $this->setRefreshTime(10000);
    }

    public function builder(): Builder
    {
        return Transaction::query()
            ->where('transactions.buyer_id', auth()->user()->buyer->id)
            ->with(['product', 'seller'])
            ->withCount([
                'chat as chat_count' => function ($query) {
                    $query->where('sender_id', '!=', auth()->id())
                        ->where('read_status', false);
                }
            ])
            ->orderBy('transactions.created_at', 'desc');
    }

    public function cancelTransaction($id)
    {
        $transaction = Transaction::where('id', $id)->firstOrFail();

        // Tambahkan pengecekan status di sini
        if ($transaction->status === TransactionStatus::DONE) {
            $this->dispatch('toast', message: 'Transaksi yang sudah selesai tidak dapat dibatalkan', data: ['position' => 'top-center', 'type' => 'warning']);
            return;
        }

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

        $this->dispatch('toast', message: 'Berhasil membatalkan transaksi', data: ['position' => 'top-center', 'type' => 'success']);
        $this->dispatch('refreshDataTable');
    }

    public function columns(): array
    {
        return [
            Column::make('Trans. Code', 'id')
                ->format(function ($value, $row, Column $column) {
                    return $row->getInvoiceCode();
                })
                ->searchable()
                ->sortable(),
            Column::make("Product", "product.name")
                ->label(fn($row, Column $column) => view('components.table.transaction.name-with-chat-count')->withRow($row))
                ->sortable()
                ->searchable(),
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
                    'row' => $row,
                ])
            )
        ];
    }
}
