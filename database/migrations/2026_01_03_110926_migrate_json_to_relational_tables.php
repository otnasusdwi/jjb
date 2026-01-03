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
        // Migrate existing JSON data to relational tables
        $packages = DB::table('travel_packages')->get();
        
        foreach ($packages as $package) {
            // Migrate itinerary
            if (!empty($package->itinerary)) {
                $itineraryData = json_decode($package->itinerary, true);
                if (is_array($itineraryData)) {
                    $dayNumber = 1;
                    foreach ($itineraryData as $day) {
                        if (!empty($day['title'])) {
                            DB::table('package_itineraries')->insert([
                                'travel_package_id' => $package->id,
                                'day_number' => $dayNumber,
                                'title' => $day['title'],
                                'description' => $day['description'] ?? '',
                                'order' => 0,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            $dayNumber++;
                        }
                    }
                }
            }
            
            // Migrate inclusions
            if (!empty($package->inclusions)) {
                $inclusionsData = json_decode($package->inclusions, true);
                if (is_array($inclusionsData)) {
                    $order = 0;
                    foreach ($inclusionsData as $description) {
                        if (!empty(trim($description))) {
                            DB::table('package_inclusions')->insert([
                                'travel_package_id' => $package->id,
                                'description' => trim($description),
                                'order' => $order++,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
            
            // Migrate exclusions
            if (!empty($package->exclusions)) {
                $exclusionsData = json_decode($package->exclusions, true);
                if (is_array($exclusionsData)) {
                    $order = 0;
                    foreach ($exclusionsData as $description) {
                        if (!empty(trim($description))) {
                            DB::table('package_exclusions')->insert([
                                'travel_package_id' => $package->id,
                                'description' => trim($description),
                                'order' => $order++,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }
        
        // Drop JSON columns from travel_packages table
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->dropColumn(['itinerary', 'inclusions', 'exclusions']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back JSON columns
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->json('itinerary')->nullable()->after('difficulty_level');
            $table->json('inclusions')->nullable()->after('itinerary');
            $table->json('exclusions')->nullable()->after('inclusions');
        });
        
        // Optionally, migrate data back from relational tables to JSON
        // (This would be complex and is typically not needed)
    }
};
