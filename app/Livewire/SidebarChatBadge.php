<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class SidebarChatBadge extends Component
{
    public int $unreadCount = 0;
    public string $route = '';
    public string $title = '';
    public string $icon = '';
    public bool $active = false;
    public bool $isSubmenu = false;

    public function mount(
        string $route,
        string $title,
        string $icon,
        bool $active = false,
        bool $isSubmenu = false
    ) {
        $this->route = $route;
        $this->title = $title;
        $this->icon = $icon;
        $this->active = $active;
        $this->isSubmenu = $isSubmenu;
        $this->refreshCount();
    }

    public function getListeners()
    {
        return [
            "echo-private:chat-received.{$this->getUserId()},Chatting" => 'refreshCount',
            'chat-read' => 'refreshCount',
        ];
    }

    private function getUserId()
    {
        return auth()->id();
    }

    public function refreshCount()
    {
        $this->unreadCount = auth()->user()->getUserUnreadChatsCount();
    }

    public function render()
    {
        return view('livewire.sidebar-chat-badge');
    }
}