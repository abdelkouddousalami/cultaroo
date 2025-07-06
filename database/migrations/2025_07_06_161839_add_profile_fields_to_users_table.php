<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->enum('user_type', ['traveler', 'host', 'both'])->default('traveler')->after('email');
            $table->string('phone')->nullable()->after('user_type');
            $table->text('bio')->nullable()->after('phone');
            $table->string('country')->nullable()->after('bio');
            $table->string('city')->nullable()->after('country');
            $table->date('date_of_birth')->nullable()->after('city');
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable()->after('date_of_birth');
            $table->json('languages')->nullable()->after('gender'); // Store as JSON array
            $table->json('interests')->nullable()->after('languages'); // Store as JSON array
            $table->string('profile_picture')->nullable()->after('interests');
            $table->boolean('is_verified')->default(false)->after('profile_picture');
            $table->timestamp('last_active_at')->nullable()->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name', 
                'user_type',
                'phone',
                'bio',
                'country',
                'city',
                'date_of_birth',
                'gender',
                'languages',
                'interests',
                'profile_picture',
                'is_verified',
                'last_active_at'
            ]);
        });
    }
};
