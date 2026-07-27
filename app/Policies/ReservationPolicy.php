<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->guest_id
            || $user->id === $reservation->property->owner_id;
    }

    public function create(User $user): bool
    {
        return $user->isGuest();
    }

    public function updateStatus(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->property->owner_id;
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->guest_id
            || $user->id === $reservation->property->owner_id;
    }
}