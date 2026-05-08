<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('insurance_plans')->onDelete('cascade');
            $table->string('policy_number')->unique();
            $table->decimal('premium_amount', 10, 2);
            $table->decimal('coverage_amount', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->date('next_renewal_date')->nullable();
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->text('policy_document')->nullable(); // Path to PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
