<?php

namespace App\Livewire\Seller\Transaction;

use App\Models\Transaction;
use Livewire\Component;

class DetailTransaction extends Component
{
    public Transaction $transaction;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        return view('livewire..seller.transaction.detail-transaction');
    }
}
