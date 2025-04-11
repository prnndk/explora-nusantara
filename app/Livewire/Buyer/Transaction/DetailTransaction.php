<?php

namespace App\Livewire\Buyer\Transaction;

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
        return view('livewire.buyer.transaction.detail-transaction');
    }
}
