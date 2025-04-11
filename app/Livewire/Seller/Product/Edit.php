<?php

namespace App\Livewire\Seller\Product;

use App\Models\File;
use App\Models\Product;
use Livewire\Component;

class Edit extends Component
{
    public Product $product;

    public $name, $description, $price, $stock, $foto_file_id;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->name = $product->nama;
        $this->description = $product->deskripsi;
        $this->price = $product->harga;
        $this->stock = $product->stok;
    }

    public function handleUpdate()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
        ]);

        //if foto_file_id is not null, update the foto_file_id
        if ($this->foto_file_id) {
            $file = File::where('id',$this->product->foto_file_id)->firstOrFail();
            //delete file in old path
            if ($file->file_path) {
                $file_path = public_path($file->file_path);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $file->delete();
        }

        $this->product->update([
            'nama' => $this->name,
            'deskripsi' => $this->description,
            'harga' => $this->price,
            'stok' => $this->stock,
            'foto_file_id' => File::where('file_path',$this->foto_file_id)->firstOrFail()->id,
        ]);

        $this->dispatch('toast', message: 'Berhasil Mengupdate Produk', data: ['position' => 'top-center', 'type' => 'success']);
    }

    public function deleteProduct(){
        $this->product->delete();
        $this->dispatch('toast', message: 'Berhasil Menghapus Produk', data: ['position' => 'top-center', 'type' => 'success']);
        $this->redirect('/dashboard/seller/product', navigate: true);
    }

    public function render()
    {
        return view('livewire..seller.product.edit');
    }
}
