<?php

namespace App\Livewire\Buyer\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProduct extends Component
{
    use WithPagination;


    public $search = '';

    public function render()
    {
        return view(
            'livewire.buyer.product.index-product',
            [
                'products' => Product::latest()
                    ->where('status', ProductStatus::APPROVED)
                    ->with('seller')
                    ->where('nama', 'like', '%' . $this->search . '%')
                    ->paginate(10)
                    ->withQueryString(),
            ]
        );
    }
}
