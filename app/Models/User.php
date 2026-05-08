<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'referred_by_agent_id',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function referredByAgent()
    {
        return $this->belongsTo(Agent::class, 'referred_by_agent_id');
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent' && $this->agent && $this->agent->isApproved();
    }
}
