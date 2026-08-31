<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            $table->string('alumni_document_path')->nullable()->after('application_message');
            $table->string('alumni_document_original_name')->nullable()->after('alumni_document_path');
            $table->unsignedInteger('alumni_document_size')->nullable()->after('alumni_document_original_name');
            $table->string('alumni_document_mime_type')->nullable()->after('alumni_document_size');
        });
    }

    public function down(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            $table->dropColumn([
                'alumni_document_path',
                'alumni_document_original_name',
                'alumni_document_size',
                'alumni_document_mime_type',
            ]);
        });
    }
};
