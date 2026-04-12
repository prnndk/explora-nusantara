<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Transaction;
use Livewire\Component;
use App\Models\Contract;

class DetailTransaction extends Component
{
    public Transaction $transaction;
    public ?Contract $contract;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
          $this->contract = $transaction->contract;
    }

    public function render()
    {
        return view('livewire..admin.transaction.detail-transaction');
    }
}
