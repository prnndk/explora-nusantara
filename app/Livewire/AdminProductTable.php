<?php

namespace App\Livewire;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class AdminProductTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Product::query()
            ->with('seller')
            ->whereIn('status', ['new_request', 'approved', 'rejected', 'pending'])
            ->orderBy('created_at', 'desc');
    }

    public function acceptProduct($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $product->update(['status' => ProductStatus::APPROVED]);
        $this->dispatch('refreshDatatable');
        $this->dispatch('toast', message: 'Berhasil aprove product', data: ['position' => 'top-center', 'type' => 'success']);
    }

    public function rejectProduct($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $product->update(['status' => ProductStatus::REJECTED]);
        $this->dispatch('refreshDatatable');
        $this->dispatch('toast', message: 'Berhasil reject product', data: ['position' => 'top-center', 'type' => 'success']);
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),
            Column::make("Product", "nama")->searchable(),
            Column::make('Description', 'deskripsi'),
            Column::make('Price', 'harga')
                ->format(function ($value) {
                    return 'Rp. ' . number_format($value, 0, ',', '.');
                }),
            Column::make('Sold', 'terjual'),
            Column::make('Stock', 'stok'),
            Column::make('Status', 'status')
                ->format(
                    fn($value, $row, Column $column) => view('components.table.product-table-badge', [
                        'status' => $value,
                    ])
                )
                ->sortable(),
            Column::make('Actions', 'id')
                ->format(
                    fn($value, $row, Column $column) => view('components.table.admin-product.table-action', [
                        'id' => $value,
                    ])
                ),
        ];
    }
}
