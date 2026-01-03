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
        Schema::table('travel_packages', function (Blueprint $table) {
            // Rename duration to duration_days
            if (Schema::hasColumn('travel_packages', 'duration')) {
                $table->renameColumn('duration', 'duration_days');
            }
            // Add duration_nights column if it doesn't exist
            if (!Schema::hasColumn('travel_packages', 'duration_nights')) {
                $table->integer('duration_nights')->nullable()->after('duration_days');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_packages', function (Blueprint $table) {
            if (Schema::hasColumn('travel_packages', 'duration_days')) {
                $table->renameColumn('duration_days', 'duration');
            }
            if (Schema::hasColumn('travel_packages', 'duration_nights')) {
                $table->dropColumn('duration_nights');
            }
        });
    }
};
