<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create new table for itinerary items
        Schema::create('package_itinerary_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_itinerary_id')->constrained('package_itineraries')->onDelete('cascade');
            $table->string('title');
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['package_itinerary_id', 'order']);
        });

        // Restructure package_itineraries - remove columns we don't need
        Schema::table('package_itineraries', function (Blueprint $table) {
            $table->dropColumn(['title', 'order']);
        });
    }

    public function down(): void
    {
        // Restore original structure
        Schema::table('package_itineraries', function (Blueprint $table) {
            $table->string('title');
            $table->integer('order')->default(0);
        });

        Schema::dropIfExists('package_itinerary_items');
    }
};
