<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'property' => [
                'id' => $this->property->id,
                'title' => $this->property->title,
                'city' => $this->property->city,
            ],
            'guest' => [
                'id' => $this->guest->id,
                'name' => $this->guest->fullName(),
            ],
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'number_of_guests' => $this->number_of_guests,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'special_request' => $this->special_request,
            'conversation_id' => $this->conversation?->id,
            'created_at' => $this->created_at,
        ];
    }
}