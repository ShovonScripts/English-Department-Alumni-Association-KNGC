<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A minimal, maintainable key/value settings store.
     *
     * Feature 14 needs a single site-level switch
     * (`leaderboard_public_enabled`) that an administrator can toggle. Rather
     * than build a generic settings framework, this tiny table covers the
     * need and can grow per-feature without ceremony.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
