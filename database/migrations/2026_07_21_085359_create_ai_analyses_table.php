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
        Schema::create('ai_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('detected_language', 10)->nullable();
            $table->enum('category', [
                'accommodation', 'check_in', 'check_out', 'wifi', 'parking',
                'restaurant', 'taxi', 'beach', 'surf_school', 'house_rules',
                'technical_problem', 'emergency', 'other',
            ])->index();
            $table->boolean('urgency')->default(false)->index();
            $table->text('generated_response')->nullable();
            $table->json('structured_output')->nullable();
            $table->decimal('confidence', 4, 3)->nullable();
            $table->timestamp('analyzed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_analyses');
    }
};
