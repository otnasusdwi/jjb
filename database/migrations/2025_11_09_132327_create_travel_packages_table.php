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
        Schema::create('travel_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('package_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('full_description');
            $table->json('highlights')->nullable();
            $table->json('includes')->nullable();
            $table->json('excludes')->nullable();
            $table->longText('terms_conditions')->nullable();
            $table->integer('duration_days');
            $table->integer('duration_nights');
            $table->decimal('price_adult', 15, 2);
            $table->decimal('price_child', 15, 2)->nullable();
            $table->decimal('price_infant', 15, 2)->nullable();
            $table->integer('min_participants')->default(1);
            $table->integer('max_participants')->default(50);
            $table->enum('difficulty_level', ['easy', 'moderate', 'challenging', 'difficult'])->default('easy');
            $table->string('departure_city')->nullable();
            $table->string('meeting_point')->nullable();
            $table->text('transportation_details')->nullable();
            $table->text('accommodation_details')->nullable();
            $table->string('main_image_path')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('video_url')->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('keywords')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['status', 'is_featured', 'category_id']);
            $table->index(['slug', 'status']);
            $table->index(['price_adult', 'status']);
            $table->fullText(['name', 'short_description', 'keywords']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_packages');
    }
};
