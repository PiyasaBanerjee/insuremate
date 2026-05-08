<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Track which agent referred this user (after agents table is created)
            $table->unsignedBigInteger('referred_by_agent_id')->nullable()->after('avatar');
            // role: customer (default) or agent
            $table->string('role')->default('customer')->after('referred_by_agent_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['referred_by_agent_id', 'role']);
        });
    }
};

