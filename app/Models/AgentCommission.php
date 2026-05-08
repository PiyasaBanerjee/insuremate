<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'policy_id',
        'user_id',
        'premium_amount',
        'commission_amount',
        'commission_rate',
        'status',
    ];

    protected $casts = [
        'premium_amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
