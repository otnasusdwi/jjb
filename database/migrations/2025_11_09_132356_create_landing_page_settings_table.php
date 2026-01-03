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
        Schema::create('landing_page_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->string('whatsapp_number', 20)->nullable();
            $table->string('greeting_message')->default('Halo! Saya siap membantu perjalanan impian Anda');
            $table->text('bio_description')->nullable();
            $table->string('profile_image_path')->nullable();
            $table->json('custom_colors')->nullable();
            $table->json('visible_categories')->nullable();
            $table->json('social_media_links')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('affiliate_id');
            $table->index(['affiliate_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_settings');
    }
};
