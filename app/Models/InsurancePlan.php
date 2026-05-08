<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurancePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'base_premium',
        'coverage_amount',
        'duration_years',
        'benefits',
        'features',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'benefits' => 'array',
        'features' => 'array',
        'base_premium' => 'decimal:2',
        'coverage_amount' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(InsuranceCategory::class, 'category_id');
    }

    public function policies()
    {
        return $this->hasMany(Policy::class, 'plan_id');
    }
}
