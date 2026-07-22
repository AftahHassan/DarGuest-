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
        Schema::create('property_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('wifi_name')->nullable();
            $table->string('wifi_password')->nullable();
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->boolean('parking')->default(false);
            $table->text('parking_info')->nullable();
            $table->text('access_instructions')->nullable();
            $table->text('house_rules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_infos');
    }
};
