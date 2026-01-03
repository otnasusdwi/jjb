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
        // Get all packages with gallery_images JSON data
        $packages = DB::table('travel_packages')
            ->whereNotNull('gallery_images')
            ->get();

        foreach ($packages as $package) {
            $galleryImages = json_decode($package->gallery_images, true);
            
            if (is_array($galleryImages) && !empty($galleryImages)) {
                foreach ($galleryImages as $order => $imagePath) {
                    DB::table('package_galleries')->insert([
                        'travel_package_id' => $package->id,
                        'image_path' => $imagePath,
                        'order' => $order,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Drop gallery_images column from travel_packages
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->dropColumn('gallery_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back gallery_images column
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->json('gallery_images')->nullable()->after('featured_image');
        });

        // Move data back to JSON
        $galleries = DB::table('package_galleries')
            ->orderBy('travel_package_id')
            ->orderBy('order')
            ->get();

        $groupedGalleries = [];
        foreach ($galleries as $gallery) {
            $groupedGalleries[$gallery->travel_package_id][] = $gallery->image_path;
        }

        foreach ($groupedGalleries as $packageId => $images) {
            DB::table('travel_packages')
                ->where('id', $packageId)
                ->update(['gallery_images' => json_encode($images)]);
        }
    }
};
