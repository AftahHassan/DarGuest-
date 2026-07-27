<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class ReservationService
{
    public function create(User $guest, array $data): Reservation
    {
        $property = Property::findOrFail($data['property_id']);

        $nights = Carbon::parse($data['check_in_date'])->diffInDays(Carbon::parse($data['check_out_date']));

        $reservation = Reservation::create([
            'guest_id' => $guest->id,
            'property_id' => $property->id,
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'number_of_guests' => $data['number_of_guests'],
            'special_request' => $data['special_request'] ?? null,
            'total_price' => $nights * $property->price_per_night,
            'status' => 'pending',
        ]);

        // Une conversation démarre automatiquement avec chaque réservation
        Conversation::create([
            'reservation_id' => $reservation->id,
            'status' => 'open',
            'started_at' => now(),
        ]);

        return $reservation->fresh('conversation');
    }

    public function updateStatus(Reservation $reservation, string $status): Reservation
    {
        $reservation->update(['status' => $status]);

        return $reservation->fresh();
    }

    public function cancel(Reservation $reservation): Reservation
    {
        $reservation->update(['status' => 'cancelled']);

        return $reservation->fresh();
    }
}