<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publication_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->string('document_path')->nullable();
            $table->string('document_original_name')->nullable();
            $table->unsignedInteger('document_size')->nullable();
            $table->string('document_mime_type')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('is_featured');
            $table->index('publication_date');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
