<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add per-membership leaderboard privacy control (Feature 14).
     *
     * Unlike `is_public` (which controls the public alumni profile), this flag
     * only controls whether a member's verified contribution total appears on
     * the public contribution leaderboard. Existing records default to true.
     */
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->boolean('show_on_leaderboard')->default(true)->after('is_public');
            $table->index(['is_public', 'show_on_leaderboard']);
        });
    }

    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropIndex(['is_public', 'show_on_leaderboard']);
            $table->dropColumn('show_on_leaderboard');
        });
    }
};
