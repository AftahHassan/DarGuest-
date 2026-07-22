<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
         'owner_id', 'title', 'description', 'city', 'address',
        'price_per_night', 'capacity', 'bedrooms', 'bathrooms',
        'status', 'latitude', 'longitude',

    ];

    protected function casts(): array {

        return [
            'price_per_night' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function owner()
    {
        return $this ->belongsTo(User::class,'owner_id');
    }
    public function images()
    {
        return $this ->hasMany(PropertyImage::class)->orderBy('position');
    }
    public function info(){
        return $this ->hasOne(PropertyInfo::class);
    }
    public function recommendations(){
        return $this->hasMany(Recommendation::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
    public function scopeAvailable($query){
        return $query->where('status', 'available');
    }
    public function scopeInCity($query, string $city){
        return $query->where('city',$city);
    }

    
    
}
