<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('insurance_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('insurance_categories', 'benefits')) {
                $table->longText('benefits')->nullable()->after('description');
            }
            if (!Schema::hasColumn('insurance_categories', 'premium_info')) {
                $table->longText('premium_info')->nullable()->after('benefits');
            }
        });

        Schema::table('insurance_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('insurance_plans', 'features')) {
                $table->json('features')->nullable()->after('benefits');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_categories', function (Blueprint $table) {
            $table->dropColumn(['benefits', 'premium_info']);
        });

        Schema::table('insurance_plans', function (Blueprint $table) {
            $table->dropColumn(['features']);
        });
    }
};
