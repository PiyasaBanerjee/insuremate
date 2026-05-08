<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    /**
     * @property \Illuminate\Support\Carbon $start_date
     * @property \Illuminate\Support\Carbon $end_date
     * @property \Illuminate\Support\Carbon $next_renewal_date
     */

    protected $fillable = [
        'user_id',
        'plan_id',
        'policy_number',
        'premium_amount',
        'coverage_amount',
        'start_date',
        'end_date',
        'next_renewal_date',
        'status',
        'policy_document',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'next_renewal_date' => 'date',
        'premium_amount' => 'decimal:2',
        'coverage_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(InsurancePlan::class, 'plan_id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function renewals()
    {
        return $this->hasMany(PolicyRenewal::class);
    }
}
