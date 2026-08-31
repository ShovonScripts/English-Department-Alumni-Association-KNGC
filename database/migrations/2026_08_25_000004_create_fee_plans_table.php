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
        Schema::create('fee_plans', function (Blueprint $table) {
            $table->id();
            // A membership type must remain deletable only while no fee plan
            // references it; historical plans stay stable for Feature 13.
            $table->foreignId('membership_type_id')->constrained('membership_types')->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('currency', 3)->default('BDT');
            $table->string('frequency', 20)->index();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->date('effective_from')->nullable()->index();
            $table->date('effective_until')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['membership_type_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_plans');
    }
};
