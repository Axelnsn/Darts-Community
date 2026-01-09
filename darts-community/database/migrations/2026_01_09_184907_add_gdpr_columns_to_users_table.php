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
            $table->timestamp('gdpr_consent_at')->nullable()->after('email_verified_at');
            $table->timestamp('gdpr_deletion_requested_at')->nullable()->after('gdpr_consent_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gdpr_consent_at');
            $table->dropColumn('gdpr_deletion_requested_at');
            $table->dropSoftDeletes();
        });
    }
};
