<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'policy_id',
        'claim_number',
        'claim_amount',
        'description',
        'status',
        'admin_remarks',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
        'claim_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
