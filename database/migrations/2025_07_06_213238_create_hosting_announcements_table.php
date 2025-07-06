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
        Schema::create('hosting_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price_per_night', 8, 2);
            $table->string('currency', 3)->default('MAD');
            $table->string('room_type'); // private_room, shared_room, entire_place
            $table->integer('max_guests')->default(1);
            $table->string('city');
            $table->string('address');
            $table->json('languages'); // Languages the host speaks
            $table->json('amenities'); // Available amenities
            $table->json('house_rules')->nullable(); // House rules
            $table->json('images')->nullable(); // Image paths
            $table->boolean('is_active')->default(true);
            $table->date('available_from')->nullable();
            $table->date('available_until')->nullable();
            $table->text('special_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_announcements');
    }
};
