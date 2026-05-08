<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.session.{session_id}', function ($user, $session_id) {
    $session = \App\Models\ChatSession::find($session_id);
    return $session && $session->user_id === $user->id;
});
