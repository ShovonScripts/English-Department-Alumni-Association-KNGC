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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('slug')->unique();
            $table->string('profile_photo')->nullable();
            $table->string('student_id')->nullable();
            $table->string('batch')->nullable()->index();
            $table->string('session')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable()->index();
            $table->string('degree')->nullable();
            $table->string('designation')->nullable();
            $table->string('organization')->nullable();
            $table->string('profession')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable()->index();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->string('status')->default('active')->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
