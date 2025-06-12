<?php

namespace App\Livewire\Buyer\Transaction;

use App\Enums\ProductStatus;
use App\Models\Contract;
use App\Models\File;
use App\Models\Transaction;
use Exception;
use Livewire\Component;

class DetailTransaction extends Component
{
    public Transaction $transaction;
    private string $transaction_id;
    public $contract_document;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->transaction_id = $transaction->id;
    }

    public function updateTransactionData()
    {
        $this->transaction = Transaction::with(['buyer', 'seller', 'product', 'contract', 'contract.file'])
            ->find($this->transaction_id);

        if (!$this->transaction) {
            return $this->dispatch('toast', message: 'Transaksi tidak ditemukan', data: ['position' => 'top-right', 'type' => 'error']);
        }

    }

    public function uploadContract()
    {
        $this->validate([
            'contract_document' => 'required|exists:files,file_path'
        ]);

        $file = File::where('file_path', $this->contract_document)->first();
        if (!$file) {
            return $this->dispatch('toast', message: 'File tidak ditemukan', data: ['position' => 'top-right', 'type' => 'error']);
        }

        $contract = new Contract();

        $contract->transaction_id = $this->transaction->id;
        $contract->file_id = $file->id;
        $contract->buyer_id = $this->transaction->buyer_id;
        $contract->seller_id = $this->transaction->seller_id;
        $contract->product_id = $this->transaction->product_id;

        $contract->save();

        $this->contract_document = null;
        //filepond reset
        $this->dispatch('filepondReset', 'contract_document');

        return $this->dispatch('toast', message: 'Berhasil upload dokumen contract', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function updateContractDocument()
    {
        try {
            $this->validate([
                'contract_document' => 'required|exists:files,file_path'
            ]);

            $file = File::where('file_path', $this->contract_document)->first();
            if (!$file) {
                throw new Exception('File not found');
            }

            $contract = $this->transaction->contract;
            if (!$contract) {
                throw new Exception('Contract not found for this transaction');
            }

            //delete old file if exists
            $old_contract_file = $contract->file->id;


            $contract->file_id = $file->id;
            $contract->status = ProductStatus::NEW_REQUEST;
            $contract->save();

            File::destroy($old_contract_file);

            $this->contract_document = null;
            //filepond reset
            $this->dispatch('filepondReset', 'contract_document');
            $this->dispatch('close-modal', 'update-contract');

            return $this->dispatch('toast', message: 'Berhasil update dokumen contract', data: ['position' => 'top-right', 'type' => 'success']);
        } catch (Exception $exception) {
            return $this->dispatch('toast', message: 'Terjadi kesalahan: ' . $exception->getMessage(), data: ['position' => 'top-right', 'type' => 'error']);
        }

    }

    public function render()
    {
        return view('livewire.buyer.transaction.detail-transaction');
    }
}