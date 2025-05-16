<?php

namespace App\Livewire\Seller\Product;

use App\Enums\ProductStatus;
use App\Models\File;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $name, $description, $price, $stock, $foto_file_id;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'foto_file_id' => 'required|exists:files,file_path',
        ];
    }

    public function handleCreation()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $product = new Product();
            $product->nama = $this->name;
            $product->deskripsi = $this->description;
            $product->harga = $this->price;
            $product->stok = $this->stock;
            $product->terjual = 0;
            $product->foto_file_id = File::where('file_path', $this->foto_file_id)->firstOrFail()->id;
            $product->status = ProductStatus::NEW_REQUEST;
            $product->seller_id = auth()->user()->seller->id;
            $product->save();

            DB::commit();
            $this->reset();

            $this->dispatch('toast', message: 'Berhasil Membuat Produk', data: ['position' => 'top-right', 'type' => 'success']);
            return redirect()->route('seller.product.index');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return $this->dispatch('toast', message: 'File tidak dapat ditemukan', data: ['position' => 'top-right', 'type' => 'error']);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->dispatch('toast', message: 'Terjadi kesalahan saat membuat produk', data: ['position' => 'top-right', 'type' => 'error']);
        }
    }

    public function render()
    {
        return view('livewire.seller.product.create');
    }
}
