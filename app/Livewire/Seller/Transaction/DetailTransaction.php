<?php

namespace App\Livewire\Seller\Transaction;

use App\Services\ContractService;
use App\Models\Transaction;
use Livewire\Component;

class DetailTransaction extends Component
{
    public Transaction $transaction;
    private string $transaction_id;
    public $contract_document;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function updateContractDocument()
    {
        try {
            $this->validate([
                'contract_document' => 'required|exists:files,file_path'
            ]);

            app(ContractService::class)->updateContractDocument(
                $this->transaction,
                $this->contract_document
            );

            $this->contract_document = null;
            $this->dispatch('filepondReset', 'contract_document');
            $this->dispatch('close-modal', 'update-contract');

            return $this->dispatch('toast', message: 'Berhasil update dokumen contract', data: ['type' => 'success']);
        } catch (\Exception $e) {
            return $this->dispatch('toast', message: $e->getMessage(), data: ['type' => 'error']);
        }
    }
    public function render()
    {
        return view('livewire.seller.transaction.detail-transaction');
    }
}
