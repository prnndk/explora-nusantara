<?php

namespace App\Livewire\Seller\Product;

use App\Models\File;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    public Product $product;

    public $name, $description, $price, $stock, $foto_file_id;

    use WithFileUploads;

    public $images = [];

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
            //'foto_file_id' => 'nullable|exists:files,id',
            'foto_file_id' => 'nullable|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|max:2048',
        ]);

        $newFile = null;

        if ($this->foto_file_id) {
            $newFile = File::where('file_path', $this->foto_file_id)->first();
        }

        if ($newFile && $newFile->id != $this->product->foto_file_id) {

            $oldFile = File::find($this->product->foto_file_id);

            if ($oldFile && $oldFile->file_path) {
                $file_path = public_path($oldFile->file_path);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                $oldFile->delete();
            }
        }

        $this->product->update([
            'nama' => $this->name,
            'deskripsi' => $this->description,
            'harga' => $this->price,
            'stok' => $this->stock,
            //'foto_file_id' => File::where('file_path', $this->foto_file_id)->first()->id ?? null,
            'foto_file_id' => $newFile ? $newFile->id : $this->product->foto_file_id,
        ]);
        $existingCount = $this->product->images()->count();
        $newCount = count($this->images);

        if (($existingCount + $newCount) > 5) {
            $this->dispatch('toast', message: 'Maksimal 5 gambar', data: ['type' => 'error']);
        }

        if (!empty($this->images)) {
            if ($existingCount >= 5) {
                return $this->dispatch('toast', message: 'Maksimal 5 gambar', data: ['type' => 'error']);
            }

            foreach ($this->images as $image) {

                if ($existingCount >= 5) break;

                $this->product->images()->create([
                    'image_path' => $image->store('products', 'public')
                ]);

                $existingCount++;
            }
        }
        $this->dispatch('toast', message: 'Berhasil Mengupdate Produk', data: ['position' => 'top-center', 'type' => 'success']);
        return redirect()->route('seller.product.index');
    }

    public function deleteImage($id)
    {
        $image = $this->product->images()->find($id);

        if ($image) {
            $path = storage_path('app/public/' . $image->image_path);

            if (file_exists($path)) {
                unlink($path);
            }

            $image->delete();
        }
    }

    public function deleteProduct()
    {
        $this->product->delete();
        $this->dispatch('toast', message: 'Berhasil Menghapus Produk', data: ['position' => 'top-center', 'type' => 'success']);
        //$this->redirect('/dashboard/seller/product', navigate: true);
        return redirect()->route('seller.product.index');
    }
    public function render()
    {
        return view('livewire.seller.product.edit');
    }
}
