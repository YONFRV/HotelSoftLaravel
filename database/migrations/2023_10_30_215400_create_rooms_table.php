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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->foreignId('typeRoom_id')->constrained('type_rooms');
            $table->foreignId('hotel_id')->constrained('hotels');
            $table->foreignId('accommodation_id')->constrained('accommodations');
            $table->string('state');
            $table->foreignId('user_create')->constrained('users');
            $table->foreignId('user_update')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
