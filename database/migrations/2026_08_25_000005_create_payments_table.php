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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Financial records anchor to memberships and specific fee plans
            // so historical references stay stable. Deletion is restricted —
            // use voiding instead of erasing financial history.
            $table->foreignId('membership_id')->constrained('memberships')->restrictOnDelete();
            $table->foreignId('fee_plan_id')->constrained('fee_plans')->restrictOnDelete();
            $table->string('payment_number', 30)->unique();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('currency', 3)->default('BDT');
            $table->string('status', 20)->index();
            $table->date('paid_at')->index();
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            // Audit fields: who recorded this collection.
            $table->foreignId('recorded_by')->constrained('users')->restrictOnDelete();

            // Void audit trail — numbers are never recycled, records never erased.
            $table->timestamp('voided_at')->nullable();
            $table->foreignId('voided_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('void_reason')->nullable();

            $table->timestamps();

            $table->index(['membership_id', 'fee_plan_id']);
            $table->index(['status', 'paid_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
