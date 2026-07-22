<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs autorisés pour le Mass Assignment.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'role',
        'avatar',
    ];

    /**
     * Les attributs masqués lors de la sérialisation.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les conversions automatiques des attributs.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Un propriétaire possède plusieurs logements.
     */
    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    /**
     * Un voyageur possède plusieurs réservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'guest_id');
    }

    /**
     * Messages envoyés par l'utilisateur.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Notifications reçues par l'utilisateur.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Scope : récupérer uniquement les propriétaires.
     */
    public function scopeOwners($query)
    {
        return $query->where('role', 'owner');
    }

    /**
     * Scope : récupérer uniquement les voyageurs.
     */
    public function scopeGuests($query)
    {
        return $query->where('role', 'guest');
    }

    /**
     * Vérifie si l'utilisateur est un propriétaire.
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Vérifie si l'utilisateur est un voyageur.
     */
    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    /**
     * Retourne le nom complet.
     */
    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}