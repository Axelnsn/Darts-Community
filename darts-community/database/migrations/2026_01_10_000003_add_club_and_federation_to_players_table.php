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
        Schema::table('players', function (Blueprint $table) {
            $table->foreignId('club_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->foreignId('federation_id')->nullable()->after('club_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropForeign(['federation_id']);
            $table->dropColumn(['club_id', 'federation_id']);
        });
    }
};
