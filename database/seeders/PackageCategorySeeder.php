<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Domestic Tours', 'description' => 'Tours within Indonesia'],
            ['name' => 'International Tours', 'description' => 'Tours to international destinations'],
            ['name' => 'Adventure', 'description' => 'Adventure and outdoor activities'],
            ['name' => 'Cultural', 'description' => 'Cultural tours and experiences'],
            ['name' => 'Beach & Marine', 'description' => 'Beach and marine activities'],
            ['name' => 'Mountain & Trekking', 'description' => 'Mountain and trekking adventures'],
            ['name' => 'City Tours', 'description' => 'Urban exploration and city tours'],
            ['name' => 'Culinary Tours', 'description' => 'Food and culinary experiences'],
            ['name' => 'Photography Tours', 'description' => 'Photography focused tours'],
            ['name' => 'Honeymoon Packages', 'description' => 'Romantic honeymoon packages'],
            ['name' => 'Group Tours', 'description' => 'Group tours and team building'],
            ['name' => 'Private Tours', 'description' => 'Private and customized tours'],
        ];

        foreach ($categories as $index => $category) {
            DB::table('package_categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'sort_order' => $index + 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
