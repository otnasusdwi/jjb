<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Destination Tags
            [
                'name' => 'Java',
                'type' => 'destination',
                'color' => '#FF8C00',
                'description' => 'Java island packages - temples, culture, heritage',
                'sort_order' => 1,
            ],
            [
                'name' => 'Bali',
                'type' => 'destination',
                'color' => '#FF8C00',
                'description' => 'Bali island packages - beaches, temples, culture',
                'sort_order' => 2,
            ],
            [
                'name' => 'Lombok',
                'type' => 'destination',
                'color' => '#FF8C00',
                'description' => 'Lombok island packages - pristine beaches, waterfalls',
                'sort_order' => 3,
            ],
            [
                'name' => 'Labuan Bajo',
                'type' => 'destination',
                'color' => '#FF8C00',
                'description' => 'Labuan Bajo packages - Komodo dragons, diving',
                'sort_order' => 4,
            ],
            [
                'name' => 'Flores',
                'type' => 'destination',
                'color' => '#FF8C00',
                'description' => 'Flores island packages - culture, trekking, heritage',
                'sort_order' => 5,
            ],
            [
                'name' => 'Long Trip',
                'type' => 'style',
                'color' => '#FF8C00',
                'description' => 'Multi-destination packages across Indonesia',
                'sort_order' => 6,
            ],
            
            // Activity Tags
            [
                'name' => 'Adventure',
                'type' => 'theme',
                'color' => '#F44336',
                'description' => 'Trekking, hiking, and adventure activities',
                'sort_order' => 10,
            ],
            [
                'name' => 'Beach',
                'type' => 'theme',
                'color' => '#03A9F4',
                'description' => 'Beach and coastal activities',
                'sort_order' => 11,
            ],
            [
                'name' => 'Culture',
                'type' => 'theme',
                'color' => '#9C27B0',
                'description' => 'Cultural experiences and heritage tours',
                'sort_order' => 12,
            ],
            [
                'name' => 'Heritage',
                'type' => 'theme',
                'color' => '#795548',
                'description' => 'Historical and heritage tours',
                'sort_order' => 13,
            ],
            [
                'name' => 'Family',
                'type' => 'audience',
                'color' => '#E91E63',
                'description' => 'Family-friendly packages',
                'sort_order' => 14,
            ],
            [
                'name' => 'Island Hopping',
                'type' => 'theme',
                'color' => '#14b8a6',
                'description' => 'Island hopping and water activities',
                'sort_order' => 15,
            ],
            [
                'name' => 'Snorkeling',
                'type' => 'activity',
                'color' => '#00BCD4',
                'description' => 'Snorkeling and water sports',
                'sort_order' => 16,
            ],
            [
                'name' => 'Trekking',
                'type' => 'activity',
                'color' => '#4CAF50',
                'description' => 'Trekking and hiking activities',
                'sort_order' => 17,
            ],
            [
                'name' => 'Volcano',
                'type' => 'theme',
                'color' => '#FF5722',
                'description' => 'Volcano and mountain activities',
                'sort_order' => 18,
            ],
            [
                'name' => 'Liveaboard',
                'type' => 'style',
                'color' => '#6366f1',
                'description' => 'Liveaboard boat experiences',
                'sort_order' => 19,
            ],
            [
                'name' => 'Wildlife',
                'type' => 'theme',
                'color' => '#8BC34A',
                'description' => 'Wildlife and nature experiences',
                'sort_order' => 20,
            ],
            [
                'name' => 'Overland',
                'type' => 'style',
                'color' => '#475569',
                'description' => 'Overland multi-destination tours',
                'sort_order' => 21,
            ],
            [
                'name' => 'Premium',
                'type' => 'style',
                'color' => '#FFD700',
                'description' => 'Premium and luxury packages',
                'sort_order' => 22,
            ],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($tag['name'])],
                $tag
            );
        }
    }
}
