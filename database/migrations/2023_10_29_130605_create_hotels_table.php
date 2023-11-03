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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('address');
            $table->string('nit');
            $table->integer('max_rooms');
            $table->integer('total_rooms_created')->nullable();
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
        Schema::dropIfExists('hotels');
    }
};
