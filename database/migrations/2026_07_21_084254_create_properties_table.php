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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('city')->index();
            $table->string('address');
            $table->decimal('price_per_night',8,2);
            $table->unsignedInteger('bedrooms');
            $table->unsignedInteger('bathrooms');
            $table->enum('status', ['available', 'unavailable', 'maintenance'])
                  ->default('available')
                  ->index();
            $table->decimal('latitude',10, 7)->nullable();
            $table->decimal('longitude',10, 7)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
