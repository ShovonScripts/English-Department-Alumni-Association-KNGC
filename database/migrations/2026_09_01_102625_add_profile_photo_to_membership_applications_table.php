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
        Schema::table('membership_applications', function (Blueprint $table) {
            $table->string('profile_photo_path')->nullable()->after('application_message');
            $table->string('profile_photo_original_name')->nullable();
            $table->unsignedInteger('profile_photo_size')->nullable();
            $table->string('profile_photo_mime_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo_path',
                'profile_photo_original_name',
                'profile_photo_size',
                'profile_photo_mime_type',
            ]);
        });
    }
};
