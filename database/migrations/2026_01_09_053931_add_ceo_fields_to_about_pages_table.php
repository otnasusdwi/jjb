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
        Schema::table('about_pages', function (Blueprint $table) {
            $table->string('ceo_name')->nullable();
            $table->string('ceo_position')->nullable();
            $table->text('ceo_message')->nullable();
            $table->string('ceo_image')->nullable();
            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_button_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->dropColumn([
                'ceo_name',
                'ceo_position', 
                'ceo_message',
                'ceo_image',
                'cta_title',
                'cta_description',
                'cta_button_text',
                'cta_button_url'
            ]);
        });
    }
};
