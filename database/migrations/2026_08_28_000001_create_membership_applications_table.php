<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();

            $table->string('application_number', 30)->unique();
            $table->foreignId('alumni_id')->nullable()->constrained('alumni')->nullOnDelete();
            $table->foreignId('membership_type_id')->constrained('membership_types');
            $table->foreignId('requested_tier_id')->nullable()->constrained('membership_tiers')->nullOnDelete();

            $table->string('full_name', 150);
            $table->string('email', 255);
            $table->string('phone', 30);
            $table->string('student_id', 50)->nullable();
            $table->string('batch', 30)->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->string('current_organization', 150)->nullable();
            $table->string('profession', 100)->nullable();
            $table->string('current_designation', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable()->default('Bangladesh');
            $table->date('date_of_birth')->nullable();
            $table->text('application_message')->nullable();

            $table->string('status', 30)->default('pending')->index();
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();

            $table->string('status_token_hash', 64)->nullable()->unique();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'submitted_at']);
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};
