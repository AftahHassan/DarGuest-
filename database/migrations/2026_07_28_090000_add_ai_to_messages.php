<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->string('sender_type', 10)->change();
            $table->unsignedBigInteger('sender_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete();
            DB::statement("ALTER TABLE messages MODIFY sender_type ENUM('guest', 'owner') NOT NULL");
            DB::statement("ALTER TABLE messages MODIFY sender_id BIGINT UNSIGNED NOT NULL");
        });
    }
};
