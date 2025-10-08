<?php

namespace App\Livewire\Admin\Contract;

use App\Enums\ProductStatus;
use App\Models\Contract;
use Livewire\Component;

class Detail extends Component
{
    public Contract $contract;


    public function mount(Contract $contract)
    {
        $this->contract = $contract;
    }
    public function approveContract()
    {
        $this->contract->update([
            'status' => ProductStatus::APPROVED
        ]);
        $this->contract->save();

        $this->dispatch('toast', message: 'Berhasil mengupdate status', data: ['position' => 'top-center', 'type' => 'success']);
    }

    public function rejectContract()
    {
        $this->contract->update([
            'status' => ProductStatus::REJECTED
        ]);
        $this->dispatch('toast', message: 'Berhasil mengupdate status', data: ['position' => 'top-center', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.admin.contract.detail');
    }
}
