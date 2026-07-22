<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable=[
         'first_name', 'last_name', 'email', 'password',
        'phone', 'role', 'avatar',
    ];

    protected $hidden =[
         'password', 'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function properties()
    {
        return $this ->hasMany(Property::class,'owner_id');
    }

    public function reservations()
    {
        return $this ->hasMany(Reservation::class,'guest_id');
    }

    public function sentMessages()
    {
        return $this ->hasMany(Message::class,'sender_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function scopeOwners($query)
    {
        return $query->where('role', 'owner');
    }

    public function scopeGuests($query)
    {
        return $query->where('role', 'guest');
    }
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
