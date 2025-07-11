<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class SellerProductTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setConfigurableArea('toolbar-right-start', 'components.table.seller-product.header-action');
    }

    public function builder(): Builder
    {
        return Product::query()
            ->where('seller_id', auth()->user()->seller->id)
            ->whereIn('status', ['new_request', 'approved', 'rejected', 'pending'])
            ->orderBy('created_at', 'desc');
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            $this->dispatch('refreshDataTable');
            $this->dispatch('close-modal', 'confirm-delete' . $id);
            $this->dispatch('toast', message: 'Berhasil Menghapus produk', data: ['position' => 'top-center', 'type' => 'success']);
        } else {
            $this->dispatch('toast', message: 'Gagal Menghapus produk', data: ['position' => 'top-center', 'type' => 'error']);
        }
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),
            Column::make("Product", "nama")->searchable(),
            Column::make('Description', 'deskripsi')
                ->format(function ($value) {
                    return \Illuminate\Support\Str::limit($value, 30);
                }),
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
                    fn($value, $row, Column $column) => view('components.table.seller-product.table-action', [
                        'id' => $value,
                    ])
                ),
        ];
    }
}