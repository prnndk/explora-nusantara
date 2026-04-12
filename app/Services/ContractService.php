<?php

namespace App\Services;

use App\Enums\ProductStatus;
use App\Models\Contract;
use App\Models\File;
use Exception;

class ContractService
{
    public function updateContractDocument($transaction, $filePath)
    {
        $file = File::where('file_path', $filePath)->first();

        if (!$file) {
            throw new Exception('File not found');
        }

        $contract = $transaction->contract;

        if (!$contract) {
            throw new Exception('Contract not found for this transaction');
        }

        // simpan file lama
        $oldFileId = $contract->file->id ?? null;

        // update contract
        $contract->file_id = $file->id;
        $contract->status = ProductStatus::NEW_REQUEST;
        $contract->save();

        // delete file lama
        if ($oldFileId) {
            File::destroy($oldFileId);
        }

        return true;
    }
}