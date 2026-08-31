<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add a composite (membership_id, status) index to support the Feature 14
     * contribution aggregation, which filters payments by status for each
     * membership. membership_id is already indexed via the existing
     * composite, but this focused pair makes the leaderboard aggregation
     * efficient without duplicating a standalone membership_id index.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->index(['membership_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['membership_id', 'status']);
        });
    }
};
