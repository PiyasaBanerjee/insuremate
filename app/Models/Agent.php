<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_code',
        'status',
        'total_earnings',
        'pending_payout',
        'commission_rate',
        'notes',
    ];

    protected $casts = [
        'total_earnings' => 'decimal:2',
        'pending_payout' => 'decimal:2',
        'commission_rate' => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commissions()
    {
        return $this->hasMany(AgentCommission::class);
    }

    // Policies sold by this agent (via commissions)
    public function policies()
    {
        return $this->hasManyThrough(Policy::class, AgentCommission::class, 'agent_id', 'id', 'id', 'policy_id');
    }

    // Clients referred by this agent
    public function clients()
    {
        return $this->hasMany(User::class, 'referred_by_agent_id');
    }

    // ── Accessors / Helpers ────────────────────────────────────────────

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function totalSales(): int
    {
        return $this->commissions()->count();
    }
}
