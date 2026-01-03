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
                'icon' => '🏛️',
                'description' => 'Java island packages - temples, culture, heritage',
                'sort_order' => 1,
            ],
            [
                'name' => 'Bali',
                'type' => 'destination',
                'color' => '#FF8C00',
                'icon' => '🏝️',
                'description' => 'Bali island packages - beaches, temples, culture',
                'sort_order' => 2,
            ],
            [
                'name' => 'Lombok',
                'type' => 'destination',
                'color' => '#FF8C00',
                'icon' => '🏖️',
                'description' => 'Lombok island packages - pristine beaches, waterfalls',
                'sort_order' => 3,
            ],
            [
                'name' => 'Labuan Bajo',
                'type' => 'destination',
                'color' => '#FF8C00',
                'icon' => '🦎',
                'description' => 'Labuan Bajo packages - Komodo dragons, diving',
                'sort_order' => 4,
            ],
            [
                'name' => 'Long Trip',
                'type' => 'destination',
                'color' => '#FF8C00',
                'icon' => '🚐',
                'description' => 'Multi-destination packages across Indonesia',
                'sort_order' => 5,
            ],
            
            // Activity Tags
            [
                'name' => 'Cultural',
                'type' => 'activity',
                'color' => '#9C27B0',
                'icon' => '🎭',
                'description' => 'Cultural experiences and heritage tours',
                'sort_order' => 10,
            ],
            [
                'name' => 'Adventure',
                'type' => 'activity',
                'color' => '#F44336',
                'icon' => '⛰️',
                'description' => 'Trekking, hiking, and adventure activities',
                'sort_order' => 11,
            ],
            [
                'name' => 'Beach',
                'type' => 'activity',
                'color' => '#03A9F4',
                'icon' => '🏖️',
                'description' => 'Beach and coastal activities',
                'sort_order' => 12,
            ],
            [
                'name' => 'Temple',
                'type' => 'activity',
                'color' => '#FF9800',
                'icon' => '⛩️',
                'description' => 'Temple visits and spiritual experiences',
                'sort_order' => 13,
            ],
            [
                'name' => 'Nature',
                'type' => 'activity',
                'color' => '#4CAF50',
                'icon' => '🌿',
                'description' => 'Nature and wildlife experiences',
                'sort_order' => 14,
            ],
            [
                'name' => 'Diving',
                'type' => 'activity',
                'color' => '#00BCD4',
                'icon' => '🤿',
                'description' => 'Diving and snorkeling activities',
                'sort_order' => 15,
            ],
            
            // Theme Tags
            [
                'name' => 'Luxury',
                'type' => 'theme',
                'color' => '#FFD700',
                'icon' => '⭐',
                'description' => 'Premium luxury experiences',
                'sort_order' => 20,
            ],
            [
                'name' => 'Budget',
                'type' => 'theme',
                'color' => '#4CAF50',
                'icon' => '💰',
                'description' => 'Budget-friendly packages',
                'sort_order' => 21,
            ],
            [
                'name' => 'Family',
                'type' => 'theme',
                'color' => '#E91E63',
                'icon' => '👨‍👩‍👧‍👦',
                'description' => 'Family-friendly packages',
                'sort_order' => 22,
            ],
            [
                'name' => 'Honeymoon',
                'type' => 'theme',
                'color' => '#FF1744',
                'icon' => '💑',
                'description' => 'Romantic honeymoon packages',
                'sort_order' => 23,
            ],
            
            // Duration Tags
            [
                'name' => '1 Day',
                'type' => 'duration',
                'color' => '#607D8B',
                'icon' => '⏱️',
                'description' => 'One day tours',
                'sort_order' => 30,
            ],
            [
                'name' => '2-3 Days',
                'type' => 'duration',
                'color' => '#607D8B',
                'icon' => '📅',
                'description' => 'Short 2-3 day packages',
                'sort_order' => 31,
            ],
            [
                'name' => '4-5 Days',
                'type' => 'duration',
                'color' => '#607D8B',
                'icon' => '📆',
                'description' => 'Medium 4-5 day packages',
                'sort_order' => 32,
            ],
            [
                'name' => '6+ Days',
                'type' => 'duration',
                'color' => '#607D8B',
                'icon' => '🗓️',
                'description' => 'Extended tours 6 days or more',
                'sort_order' => 33,
            ],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
