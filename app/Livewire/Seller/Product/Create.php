<?php

namespace App\Livewire\Seller\Product;

use App\Enums\ProductStatus;
use App\Models\File;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use App\Models\ProductImage;

class Create extends Component
{
    use WithFileUploads;
    public $name, $description, $price, $stock, $foto_file_id;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'foto_file_id' => 'required|exists:files,file_path',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|max:2048',
        ];
    }
    public $images = [];

    public $category_id;
    public $categories = [];

    public function mount()
    {
        $this->categories = Category::all();
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
            $product->category_id = $this->category_id;
            $product->seller_id = auth()->user()->seller->id;
            $product->save();
            if ($this->images) {
                foreach ($this->images as $image) {
                    $product->images()->create([
                        'image_path' => $image->store('products', 'public')
                    ]);
                }
            }
            DB::commit();
            $this->reset();

            $this->dispatch('toast', message: 'Berhasil Membuat Produk', data: ['position' => 'top-right', 'type' => 'success']);
            $this->redirect(route('seller.product.index'), navigate: true);
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
