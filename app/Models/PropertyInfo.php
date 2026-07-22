<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'wifi_name', 'wifi_password',
        'check_in', 'check_out', 'parking', 'parking_info',
        'access_instructions', 'house_rules',
    ];

    protected function casts(): array
    {
        return [
            'parking' => 'boolean',
        ];
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
