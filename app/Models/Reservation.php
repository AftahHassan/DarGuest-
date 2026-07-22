<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guest_id', 'property_id', 'check_in_date', 'check_out_date',
        'number_of_guests', 'total_price', 'status', 'special_request',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'total_price' => 'decimal:2',
        ];
    }
    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }
}
