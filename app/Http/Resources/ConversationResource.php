<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'reservation' => [
                'id' => $this->reservation->id,
                'property_title' => $this->reservation->property->title,
                'guest_name' => $this->reservation->guest->fullName(),
            ],
            'started_at' => $this->started_at,
            'messages_count' => $this->messages()->count(),
        ];
    }
}