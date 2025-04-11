<?php

namespace App\Livewire\Buyer\Product;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CheckoutProduct extends Component
{
    public Product $product;

    public $quantity = 1;
    public $shipping_address, $payment_method;

    public $totalPrice;

    public $totaled;

    public $note_to_seller;

    public function rules()
    {
        return [
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
            'note_to_seller' => 'nullable|string|max:30',
        ];
    }

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->shipping_address = auth()->user()->buyer->address;
        $this->totalPrice = $product->harga;
        $this->totaled = 200000 + 5000 + 20000;
    }

    public function checkout()
    {
        try {
            $this->validate();
            $transaction = new Transaction();
            $transaction->product_id = $this->product->id;
            $transaction->buyer_id = auth()->user()->buyer->id;
            $transaction->seller_id = $this->product->seller->id;
            $transaction->total_harga = $this->totaled;

            $transaction->save();
        } catch (ValidationException $exception) {
            $this->setErrorBag($exception->validator->errors());
            $this->dispatch('toast', message: 'Error: ' . $exception->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        } catch (\Exception $exception) {
            $this->dispatch('toast', message: 'Error: ' . $exception->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        }

        $this->dispatch('toast', message: 'Checkout successful', data: ['position' => 'top-center', 'type' => 'success']);
        $this->dispatch('close-modal', 'checkout-product');

        return $this->redirect("/dashboard/buyer/product/checkout-success", navigate: true);
    }

    public function updateAddress()
    {
        $this->dispatch('toast', message: 'Address updated', data: ['position' => 'top-center', 'type' => 'info']);
        $this->dispatch('close-modal', 'change-address');
    }

    public function render()
    {
        return view('livewire..buyer.product.checkout-product');
    }
}
