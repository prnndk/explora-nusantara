<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Events\Chatting;
use App\Models\Transaction;
use Exception;
use Livewire\Component;
use App\Models\TransactionChat as TransactionChatModel;

class TransactionChat extends Component
{
    public Transaction $transaction;
    public $transactionChats;
    public $message;

    public $user_id;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->user_id = auth()->id();
        $this->updateChats();
    }

    public function updateChats()
    {
        $this->transactionChats = TransactionChatModel::where('transaction_id', $this->transaction->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
        $this->dispatch('messageUpdated');
    }

    public function getListeners()
    {
        return [
            "echo-private:chat-received.{$this->user_id},Chatting" => 'updateChats',
        ];
    }

    public function sendMessage()
    {
        try {
            $this->validate([
                'message' => 'required|string|max:500',
            ]);

            $transaction = $this->transaction;

            TransactionChatModel::create([
                'transaction_id' => $transaction->id,
                'sender_id' => auth()->id(),
                'message' => $this->message,
            ]);

            $this->updateChats();

            if (auth()->user()->role === UserRole::BUYER) {
                $receiverId = $transaction->seller->user_id;
            } elseif (auth()->user()->role === UserRole::SELLER) {
                $receiverId = $transaction->buyer->user_id;
            } else {
                throw new Exception('Invalid user role for chat');
            }

            Chatting::dispatch($transaction->id, $receiverId);
            $this->dispatch('messageUpdated');
            $this->message = '';
        } catch (Exception $e) {
            return $this->dispatch('toast', message: 'Terjadi kesalahan, ' . $e->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
        }
    }

    public function render()
    {
        return view('livewire.transaction-chat');
    }

}