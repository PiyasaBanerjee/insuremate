<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'benefits',
        'premium_info',
        'is_active',
    ];

    public function plans()
    {
        return $this->hasMany(InsurancePlan::class, 'category_id');
    }
}
