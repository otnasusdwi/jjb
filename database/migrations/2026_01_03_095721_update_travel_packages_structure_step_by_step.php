<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop fulltext index first
        try {
            DB::statement('ALTER TABLE travel_packages DROP INDEX travel_packages_name_short_description_keywords_fulltext');
        } catch (\Exception $e) {
            // Index might not exist
        }
        
        // Drop columns one by one
        $columnsToDrop = [
            'category_id', 'created_by', 'short_description', 'highlights', 'includes', 
            'excludes', 'terms_conditions', 'duration_days', 'duration_nights', 
            'price_adult', 'price_child', 'price_infant', 'min_participants',
            'departure_city', 'meeting_point', 'transportation_details', 
            'accommodation_details', 'main_image_path', 'video_url', 'virtual_tour_url',
            'commission_rate', 'is_featured', 'seo_title', 'seo_description'
        ];
        
        foreach ($columnsToDrop as $column) {
            if (Schema::hasColumn('travel_packages', $column)) {
                Schema::table('travel_packages', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
        
        // Modify status enum
        DB::statement("ALTER TABLE travel_packages MODIFY status ENUM('draft', 'active', 'inactive') DEFAULT 'draft'");
        
        // Add indexes
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->index(['status', 'category'], 'idx_status_category');
            $table->index(['price', 'status'], 'idx_price_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a destructive migration, down() might lose data
        Schema::table('travel_packages', function (Blueprint $table) {
            // Drop new indexes
            $table->dropIndex(['status', 'category']);
            $table->dropIndex(['price', 'status']);
        });
        
        Schema::table('travel_packages', function (Blueprint $table) {
            // Restore old columns
            $table->foreignId('category_id')->nullable()->after('id');
            $table->foreignId('created_by')->nullable()->after('keywords');
            $table->text('short_description')->nullable();
            $table->json('highlights')->nullable();
            $table->json('includes')->nullable();
            $table->json('excludes')->nullable();
            $table->longText('terms_conditions')->nullable();
            $table->integer('duration_nights')->nullable();
            $table->decimal('price_adult', 15, 2)->nullable();
            $table->decimal('price_child', 15, 2)->nullable();
            $table->decimal('price_infant', 15, 2)->nullable();
            $table->integer('min_participants')->default(1);
            $table->string('departure_city')->nullable();
            $table->string('meeting_point')->nullable();
            $table->text('transportation_details')->nullable();
            $table->text('accommodation_details')->nullable();
            $table->string('main_image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->boolean('is_featured')->default(false);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
        });
        
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->renameColumn('description', 'full_description');
        });
        
        Schema::table('travel_packages', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'category',
                'location',
                'duration',
                'currency',
                'price',
                'child_price',
                'itinerary',
                'inclusions',
                'exclusions',
                'featured_image',
                'meta_title',
                'meta_description',
            ]);
        });
        
        // Restore foreign keys and indexes
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('package_categories')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status', 'is_featured', 'category_id']);
            $table->index(['price_adult', 'status']);
        });
    }
};
