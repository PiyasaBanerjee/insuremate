<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('agent_code')->unique(); // e.g. AGT-9X1K
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->decimal('total_earnings', 12, 2)->default(0);
            $table->decimal('pending_payout', 12, 2)->default(0);
            $table->decimal('commission_rate', 5, 2)->default(10.00); // 10% default
            $table->text('notes')->nullable(); // admin notes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
