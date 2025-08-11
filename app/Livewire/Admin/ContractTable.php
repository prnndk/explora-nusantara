<?php

namespace App\Livewire\Admin;

use App\Enums\ProductStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Contract;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;
use Str;

class ContractTable extends DataTableComponent
{
    protected $model = Contract::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function approveContract($id)
    {
        $contract = Contract::where('id', $id)->firstOrFail();
        $contract->update([
            'status' => ProductStatus::APPROVED
        ]);
        $this->dispatch('toast', message: 'Berhasil mengupdate status', data: ['position' => 'top-center', 'type' => 'success']);
        $this->dispatch('refreshDataTable');
    }

    public function cancelContract($id)
    {
        $contract = Contract::where('id', $id)->firstOrFail();
        $contract->update([
            'status' => ProductStatus::REJECTED
        ]);
        $this->dispatch('toast', message: 'Berhasil mengupdate status', data: ['position' => 'top-center', 'type' => 'success']);
        $this->dispatch('refreshDataTable');
    }


    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),
            Column::make('Product', 'product.nama')
                ->format(
                    fn($value, $row, Column $column) => Str::limit($value, 50, '...')
                )
                ->searchable()
                ->sortable(),
            Column::make('Buyer', 'buyer.name'),
            Column::make('Supplier', 'seller.name'),
            Column::make('Status', 'status')
                ->format(
                    fn($value, $row, Column $column) => view('components.table.product-table-badge', [
                        'status' => $value,
                    ])
                )
                ->sortable(),
            Column::make('Actions', 'id')
                ->format(
                    fn($value, $row, Column $column) => view('components.table.admin-contract-action', [
                        'id' => $value,
                    ])
                ),

        ];
    }
}