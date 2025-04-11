<?php

namespace App\Livewire\Seller\Product;

use App\Enums\ProductStatus;
use App\Models\File;
use App\Models\Product;
use Livewire\Component;

class Create extends Component
{
    public $name,$description,$price,$stock,$foto_file_id;

    public function rules(){
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'foto_file_id' => 'required',
        ];
    }

    public function handleCreation(){
        $this->validate();

        $product = new Product();
        $product->nama = $this->name;
        $product->deskripsi = $this->description;
        $product->harga = $this->price;
        $product->stok = $this->stock;
        $product->terjual = 0;
        $product->foto_file_id = File::where('file_path',$this->foto_file_id)->firstOrFail()->id;
        $product->status = ProductStatus::NEW_REQUEST;
        $product->seller_id = auth()->user()->seller->id;
        $product->save();


        $this->dispatch('toast', message: 'Berhasil Membuat Produk', data: ['position' => 'top-right', 'type' => 'success']);

        $this->reset();
    }

    public function render()
    {
        return view('livewire..seller.product.create');
    }
}
