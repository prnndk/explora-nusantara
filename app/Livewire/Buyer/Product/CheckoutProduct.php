<?php

namespace App\Livewire\Buyer\Product;

use App\Models\Alamat;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CheckoutProduct extends Component
{
    public Product $product;

    public $quantity = 1;
    public $shipping_address, $payment_method, $shipping_address_name, $user, $shipping_address_input, $shipping_address_name_input;

    public $user_alamat;

    public $totalPrice;

    public $totaled;

    public $note_to_seller;

    public $ongkir = [
        'economic' => 20000,
        'reguler' => 50000,
        'premium' => 100000,
    ];

    public $shippingCost;

    public function rules()
    {
        return [
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:BCA,BNI,BRI,MANDIRI',
            'shipping_address_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'note_to_seller' => 'nullable|string|max:30',
        ];
    }

    public function back()
    {
        return redirect()->route('buyer.product.index');
    }

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->user = Auth::user();
        $this->reloadAlamat();
        $this->totalPrice = $product->harga;
        $this->shippingCost = $this->ongkir['economic'];
        $this->totaled = $this->shippingCost + 5000 + 20000;
    }

    public function checkout()
    {
        DB::beginTransaction();
        try {
            $this->validate();

            if ($this->quantity > $this->product->stok) {
                throw ValidationException::withMessages([
                    'quantity' => 'Quantity exceeds available stock.',
                ]);
            }

            $transaction = new Transaction();
            $transaction->product_id = $this->product->id;
            $transaction->buyer_id = $this->user->buyer->id;
            $transaction->seller_id = $this->product->seller->id;
            $transaction->kuantitas_pembelian = $this->quantity;
            $transaction->subtotal_produk = $this->product->harga * $this->quantity;
            $transaction->subtotal_shipping = $this->shippingCost;
            $transaction->subtotal_asuransi = 2000;
            $transaction->subtotal_service = 5000;
            $transaction->total = $this->totalPrice * $this->quantity + $this->shippingCost + 2000 + 5000;
            $transaction->total_harga = $this->totaled;
            $transaction->payment_method = $this->payment_method;
            $transaction->pengiriman = $this->shipping_address;
            $transaction->note_to_seller = $this->note_to_seller;

            $this->product->stok = $this->product->stok - $this->quantity;
            $this->product->terjual += $this->quantity;
            $this->product->save();

            $transaction->save();
            DB::commit();
        } catch (ValidationException $exception) {
            DB::rollBack();
            $this->setErrorBag($exception->validator->errors());
            $this->dispatch('toast', message: 'Error: ' . $exception->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->dispatch('toast', message: 'Error: ' . $exception->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        }

        $this->dispatch('toast', message: 'Checkout successful', data: ['position' => 'top-center', 'type' => 'success']);

        return $this->redirect("/dashboard/buyer/product/checkout-success", navigate: true);
    }

    public function updateAddress()
    {
        $this->validate([
            'shipping_address_input' => 'required|string|max:255|unique:alamats,nama',
            'shipping_address_name_input' => 'required|string|max:255',
        ]);

        $alamat = new Alamat();
        $alamat->user_id = $this->user->id;
        $alamat->alamat = $this->shipping_address_input;
        $alamat->nama = $this->shipping_address_name_input;
        $alamat->save();

        $this->reloadAlamat();

        $this->dispatch('toast', message: 'Address updated', data: ['position' => 'top-center', 'type' => 'info']);
        $this->dispatch('close-modal', 'change-address');
    }

    public function selectAddress($alamatId)
    {
        $alamat = Alamat::find($alamatId);
        if ($alamat) {
            $this->shipping_address = $alamat->alamat;
            $this->shipping_address_name = $alamat->nama;
        }
    }

    public function reloadAlamat()
    {
        $this->user_alamat = Alamat::where('user_id', $this->user->id)->get();
    }

    public function render()
    {
        return view('livewire.buyer.product.checkout-product');
    }
}
