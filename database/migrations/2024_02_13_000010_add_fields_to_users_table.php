<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->text('address')->nullable()->after('password');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('pincode')->nullable()->after('state');
            $table->string('profile_photo_path')->nullable()->after('pincode');
            $table->boolean('is_admin')->default(false)->after('id'); // Alternative to separate admins table, but we will use separate table as requested. Keeping this for hybrid approach if needed or User Role.
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'date_of_birth', 'address', 'city', 'state', 'pincode', 'profile_photo_path', 'is_admin']);
        });
    }
};
