<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return $user->id === $id;
});

Broadcast::channel('chat-received.{receiver_id}', function ($user, $receiver_id) {
    return $user->id === $receiver_id;
});