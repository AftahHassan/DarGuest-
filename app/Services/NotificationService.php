<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Notification;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;

class NotificationService
{
    public function newReservation(Reservation $reservation): void
    {
        $owner = $reservation->property->owner;

        Notification::create([
            'user_id' => $owner->id,
            'title' => 'Nouvelle réservation',
            'content' => "{$reservation->guest->fullName()} a réservé {$reservation->property->title} du {$reservation->check_in_date->format('d/m/Y')} au {$reservation->check_out_date->format('d/m/Y')}.",
            'type' => 'new_reservation',
        ]);
    }

    public function reservationCancelled(Reservation $reservation, string $cancelledByRole): void
    {
        // Notifie l'autre partie que celle qui a annulé
        $recipient = $cancelledByRole === 'guest'
            ? $reservation->property->owner
            : $reservation->guest;

        Notification::create([
            'user_id' => $recipient->id,
            'title' => 'Réservation annulée',
            'content' => "La réservation pour {$reservation->property->title} ({$reservation->check_in_date->format('d/m/Y')} - {$reservation->check_out_date->format('d/m/Y')}) a été annulée.",
            'type' => 'reservation_cancelled',
        ]);
    }

    public function newPropertyAvailable(Property $property): void
    {
        $guests = User::guests()->get();

        foreach ($guests as $guest) {
            Notification::create([
                'user_id' => $guest->id,
                'title' => 'Nouveau logement disponible',
                'content' => "Un nouveau logement « {$property->title} » à {$property->city} est maintenant disponible à {$property->price_per_night} MAD/nuit.",
                'type' => 'new_property',
            ]);
        }
    }

    public function newMessage(Message $message): void
    {
        $reservation = $message->conversation->reservation;

        // Le destinataire est l'autre personne que l'expéditeur
        $recipient = $message->sender_id === $reservation->guest_id
            ? $reservation->property->owner
            : $reservation->guest;

        Notification::create([
            'user_id' => $recipient->id,
            'title' => 'Nouveau message',
            'content' => "{$message->sender->fullName()} : \"".\Illuminate\Support\Str::limit($message->message, 80)."\"",
            'type' => 'new_message',
        ]);
    }
}