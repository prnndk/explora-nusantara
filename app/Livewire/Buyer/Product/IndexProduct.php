<?php

namespace App\Livewire\Buyer\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class IndexProduct extends Component
{
    use WithPagination;


    public $search = '';
    public $category = null;

    public function filterCategory($id)
    {
        $this->category = $id;
        $this->resetPage(); // supaya pagination reset
    }

    public function render()
    {
        return view('livewire.buyer.product.index-product', [
            'categories' => Category::orderBy('name')->get(),

            'products' => Product::latest()
                ->where('status', ProductStatus::APPROVED)
                ->with(['seller', 'category'])
                ->when($this->category, function ($query) {
                    $query->where('category_id', $this->category);
                })
                ->where('nama', 'like', '%' . $this->search . '%')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }
}
