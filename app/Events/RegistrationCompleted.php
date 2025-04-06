<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RegistrationCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * The user instance that created.
     *
     * @var \App\Models\User
     */
    protected User $user;

    public string $user_id;

    public string $name;

    public string $action;

    /**
     * Where the user was created.
     *
     * @var string
     */
    protected string $via;

    public string $ip_address;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $via, string $ip_address, string $user_id)
    {
        $this->user_id = $user_id;
        $this->name = 'User has completed registration process ' . $user->username . ' via ' . $via;
        $this->action = 'User Completion Registration';
        $this->ip_address = $ip_address;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
