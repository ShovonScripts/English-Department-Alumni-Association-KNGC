<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_page_metas', function (Blueprint $table) {
            $table->id();
            $table->string('uri')->unique()->comment('Page URI path, e.g. /about, /news, /news/{slug}');
            $table->string('title')->nullable()->comment('Meta title override');
            $table->text('description')->nullable()->comment('Meta description override');
            $table->string('keywords')->nullable()->comment('Meta keywords, comma-separated');
            $table->string('og_title')->nullable()->comment('Open Graph title override');
            $table->text('og_description')->nullable()->comment('Open Graph description override');
            $table->string('og_image')->nullable()->comment('Open Graph image path');
            $table->string('og_type')->nullable()->default('website')->comment('Open Graph type');
            $table->string('twitter_title')->nullable()->comment('Twitter Card title override');
            $table->text('twitter_description')->nullable()->comment('Twitter Card description override');
            $table->string('twitter_image')->nullable()->comment('Twitter Card image path');
            $table->string('twitter_card')->nullable()->default('summary_large_image')->comment('Twitter card type');
            $table->boolean('noindex')->default(false)->comment('Prevent search engine indexing');
            $table->boolean('nofollow')->default(false)->comment('Prevent following links on this page');
            $table->string('canonical')->nullable()->comment('Custom canonical URL');
            $table->text('schema_markup')->nullable()->comment('Custom JSON-LD structured data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_page_metas');
    }
};
