<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'city' => $this->city,
            'address' => $this->address,
            'price_per_night' => $this->price_per_night,
            'capacity' => $this->capacity,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'status' => $this->status,
            'owner_id' => $this->owner_id,
            'images' => PropertyImageResource::collection($this->whenLoaded('images')),
            'info' => new PropertyInfoResource($this->whenLoaded('info')),
            'recommendations' => RecommendationResource::collection($this->whenLoaded('recommendations')),
            'created_at' => $this->created_at,
        ];
    }
}
