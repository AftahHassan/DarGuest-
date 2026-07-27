<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation): bool
    {
        $reservation = $conversation->reservation;

        return $user->id === $reservation->guest_id
            || $user->id === $reservation->property->owner_id;
    }
}