<?php

namespace App\Livewire\Buyer\Product;

use App\Models\Product;
use Livewire\Component;

class DetailProduct extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }


    public function render()
    {
        return view('livewire..buyer.product.detail-product');
    }
}
