<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Use Hash facade for password

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@insurance.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        $categories = [
            [
                'name' => 'Term Life Insurance',
                'slug' => 'term-life-insurance',
                'description' => 'Secure your family\'s future with our Term Life Insurance plans.',
            ],
            [
                'name' => 'Health Insurance',
                'slug' => 'health-insurance',
                'description' => 'Comprehensive health coverage for you and your loved ones.',
            ],
            [
                'name' => 'Investment Plans',
                'slug' => 'investment-plans',
                'description' => 'Grow your wealth with our tailored investment plans.',
            ],
            [
                'name' => 'Car Insurance',
                'slug' => 'car-insurance',
                'description' => 'Protect your vehicle against damages and theft.',
            ],
            [
                'name' => 'Two Wheeler Insurance',
                'slug' => 'two-wheeler-insurance',
                'description' => 'Comprehensive coverage for your bike or scooter.',
            ],
            [
                'name' => 'Family Health Insurance',
                'slug' => 'family-health-insurance',
                'description' => 'Health protection for your entire family under one plan.',
            ],
            [
                'name' => 'Travel Insurance',
                'slug' => 'travel-insurance',
                'description' => 'Travel the world worry-free with our travel insurance.',
            ],
            [
                'name' => 'Team Insurance',
                'slug' => 'team-insurance',
                'description' => 'Coverage for your sports or professional teams.',
            ],
            [
                'name' => 'Employee Group Insurance',
                'slug' => 'employee-group-insurance',
                'description' => 'Group health and life insurance for employees.',
            ],
            [
                'name' => 'Home Insurance',
                'slug' => 'home-insurance',
                'description' => 'Protect your home and belongings against risks.',
            ],
            [
                'name' => 'Retirement Plans',
                'slug' => 'retirement-plans',
                'description' => 'Plan for a secure and comfortable retirement.',
            ],
            [
                'name' => 'Guaranteed Return Plans',
                'slug' => 'guaranteed-return-plans',
                'description' => 'Investments with guaranteed returns for peace of mind.',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\InsuranceCategory::firstOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
