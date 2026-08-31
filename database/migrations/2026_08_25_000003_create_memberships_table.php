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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            // One membership record per alumnus. History of payments will
            // hang off this record in later features, so the relationship
            // is kept unique at the database level.
            $table->foreignId('alumni_id')->unique()->constrained('alumni')->cascadeOnDelete();
            $table->foreignId('membership_type_id')->constrained('membership_types')->restrictOnDelete();
            $table->foreignId('membership_tier_id')->nullable()->constrained('membership_tiers')->nullOnDelete();
            $table->string('membership_number', 20)->unique();
            $table->string('status', 20)->default('pending')->index();
            $table->date('joined_at')->nullable();
            $table->date('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_public')->default(false)->index();
            $table->timestamps();

            $table->index(['status', 'is_public']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
