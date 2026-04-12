<?php

namespace App\Livewire\Admin\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
use Livewire\Component;

class Edit extends Component
{
    public Product $product;
    public $name, $description, $price, $stock;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->name = $product->nama;
        $this->description = $product->deskripsi;
        $this->price = $product->harga;
        $this->stock = $product->stok;
    }

    public function approveTransaction()
    {
        $this->product->update([
            'status' => ProductStatus::APPROVED,
        ]);

        $this->dispatch('toast', message: 'Produk berhasil di-approve', data: [
            'position' => 'top-center',
            'type' => 'success'
        ]);

        return redirect()->route('admin.product.index');
    }

    public function rejectTransaction()
    {
        $this->product->update([
            'status' => ProductStatus::REJECTED,
        ]);

        $this->dispatch('toast', message: 'Produk berhasil di-reject', data: [
            'position' => 'top-center',
            'type' => 'success'
        ]);

        return redirect()->route('admin.product.index');
    }

    public function render()
    {
        return view('livewire.admin.product.edit');
    }
}
