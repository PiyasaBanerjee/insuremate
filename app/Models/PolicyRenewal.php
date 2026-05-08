<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'renewal_date',
        'new_end_date',
        'amount_paid',
        'payment_status',
    ];

    protected $casts = [
        'renewal_date' => 'date',
        'new_end_date' => 'date',
        'amount_paid' => 'decimal:2',
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
