<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Events\Chatting;
use App\Models\Transaction;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\TransactionChat as TransactionChatModel;

class TransactionChat extends Component
{
    public Transaction $transaction;
    public $transactionChats;
    public $message;

    public $user_id;

    public $unreadChatsCount = 0;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->user_id = auth()->id();
        $this->updateChats();
        $this->updateUnreadCount();
    }

    public function updateChats()
    {
        $this->transactionChats = TransactionChatModel::where('transaction_id', $this->transaction->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
        $this->updateUnreadCount();
        $this->dispatch('messageUpdated');
    }

    private function updateUnreadCount()
    {
        $this->unreadChatsCount = TransactionChatModel::where('transaction_id', $this->transaction->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('read_status', false)
            ->count();
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

    #[On('updateChats')]
    public function updateReadStatus($chatId)
    {
        try {
            $chat = TransactionChatModel::findOrFail($chatId);
            if ($chat->sender_id !== auth()->id()) {
                $chat->update(['read_status' => true]);
                // Mark all previous message as read if exists
                $previousChat = TransactionChatModel::where('transaction_id', $chat->transaction_id)
                    ->where('id', '<', $chat->id)
                    ->where('sender_id', '!=', auth()->id())
                    ->orderBy('id', 'desc')
                    ->first();
                if ($previousChat && !$previousChat->read_status) {
                    $previousChat->update(['read_status' => true]);
                }
            }
        } catch (Exception $e) {
            return $this->dispatch('toast', message: 'Terjadi kesalahan saat memperbarui status baca: ' . $e->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
        }
    }

    public function render()
    {
        return view('livewire.transaction-chat');
    }

}
