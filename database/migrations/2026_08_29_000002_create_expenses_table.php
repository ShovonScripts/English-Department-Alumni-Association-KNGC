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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            // Expense records anchor to a category so historical references
            // stay stable. Deletion is restricted — void the expense instead
            // of erasing association financial history.
            $table->foreignId('expense_category_id')->constrained('expense_categories')->restrictOnDelete();
            $table->string('expense_number', 30)->unique();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('currency', 3)->default('BDT');
            $table->string('status', 20)->index();
            $table->date('expense_date')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            // Audit fields: who recorded this expense.
            $table->foreignId('recorded_by')->constrained('users')->restrictOnDelete();

            // Void audit trail — numbers are never recycled, records never erased.
            $table->timestamp('voided_at')->nullable();
            $table->foreignId('voided_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('void_reason')->nullable();

            $table->timestamps();

            $table->index(['status', 'expense_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
