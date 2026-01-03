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
        Schema::create('package_exclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_package_id')->constrained('travel_packages')->onDelete('cascade');
            $table->string('description');
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['travel_package_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_exclusions');
    }
};
