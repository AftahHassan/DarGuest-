<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (! $this->resource) {
            return [];
        }

        return [
            'wifi_name' => $this->wifi_name,
            'wifi_password' => $this->wifi_password,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'parking' => $this->parking,
            'parking_info' => $this->parking_info,
            'access_instructions' => $this->access_instructions,
            'house_rules' => $this->house_rules,
        ];
    }
}