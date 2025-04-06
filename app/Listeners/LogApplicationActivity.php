<?php

namespace App\Listeners;

use App\Events\RegistrationCompleted;
use App\Events\UserCreated;
use Illuminate\Support\Str;
use App\Models\ApplicationHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogApplicationActivity
{
    /**
     * Actor that triggering event.
     *
     * @var string
     */
    protected string $user_id;
    /**
     * Name of the event.
     */
    protected string $name;
    /**
     * Action that triggered the event.
     */
    protected string $action;
    /**
     * IP address of the actor.
     */
    protected string $ip_address;

    /**
     * Create the event listener.
     */
    // public function __construct(string $user_id, string $name, string $action, string $ip_address)
    // {
    //     $this->user_id = $user_id;
    //     $this->name = $name;
    //     $this->action = $action;
    //     $this->ip_address = $ip_address;
    // }

    /**
     * Handle the event.
     */
    public function handle(UserCreated|RegistrationCompleted $event): void
    {

        DB::beginTransaction();
        try {
            ApplicationHistory::create([
                'uuid' => Str::uuid(),
                'user_id' => $event->user_id,
                'name' => $event->name,
                'action' => $event->action,
                'ip_address' => $event->ip_address,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } finally {
            DB::commit();
        }
    }
}
