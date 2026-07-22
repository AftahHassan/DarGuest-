<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recommendation extends Model
{
    use HasFactory;
     protected $fillable = [
        'property_id', 'category', 'title',
        'description', 'address', 'phone', 'website',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
