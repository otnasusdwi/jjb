<?php

namespace Database\Seeders;

use App\Models\TravelPackage;
use App\Models\PackageCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user as creator
        $admin = User::where('role', 'admin')->first();

        // Get categories
        $categories = PackageCategory::all();

        $packages = [
            // Adventure & Outdoor Packages
            [
                'category_id' => $categories->where('slug', 'adventure-outdoor')->first()?->id ?? 1,
                'name' => 'Mount Batur Sunrise Trekking Adventure',
                'slug' => 'mount-batur-sunrise-trekking',
                'short_description' => 'Experience the breathtaking sunrise from Mount Batur volcano with guided trekking adventure',
                'full_description' => 'Embark on an unforgettable journey to witness the spectacular sunrise from the summit of Mount Batur, one of Bali\'s most active volcanoes. This early morning adventure begins with a pre-dawn pickup from your hotel, followed by a guided trek through volcanic landscapes under the starlit sky. As you reach the summit, you\'ll be rewarded with panoramic views of Lake Batur, Mount Abang, and the majestic Mount Agung in the distance. The experience includes a traditional Balinese breakfast cooked using natural volcanic steam.',
                'highlights' => json_encode([
                    'Spectacular sunrise views from 1,717 meters above sea level',
                    'Guided trekking with experienced local guides',
                    'Volcanic breakfast cooked naturally with volcanic steam',
                    'Panoramic views of Lake Batur and surrounding mountains',
                    'Optional visit to natural hot springs after trek',
                    'Small group experience (maximum 12 people)'
                ]),
                'includes' => json_encode([
                    'Hotel pickup and drop-off in Ubud/Sanur/Denpasar area',
                    'Professional English-speaking trekking guide',
                    'Flashlight and trekking stick',
                    'Volcanic breakfast on the summit',
                    'Mineral water during trek',
                    'Entrance fees to Mount Batur',
                    'Insurance coverage'
                ]),
                'excludes' => json_encode([
                    'Personal expenses and souvenirs',
                    'Tips for guide and driver',
                    'Hot springs entrance fee (optional)',
                    'Additional food and beverages',
                    'Hotel pickup outside specified areas (additional charge applies)'
                ]),
                'terms_conditions' => 'Minimum age 12 years. Moderate fitness level required. Weather dependent activity. Cancellation 24 hours prior for full refund.',
                'duration_days' => 1,
                'duration_nights' => 0,
                'price_adult' => 750000,
                'price_child' => 500000,
                'price_infant' => 0,
                'min_participants' => 2,
                'max_participants' => 12,
                'difficulty_level' => 'moderate',
                'departure_city' => 'Denpasar/Ubud/Sanur',
                'meeting_point' => 'Hotel lobby (pickup service included)',
                'transportation_details' => 'Air-conditioned vehicle with experienced driver',
                'accommodation_details' => null,
                'main_image_path' => 'packages/mount-batur-sunrise.jpg',
                'gallery_images' => json_encode([
                    'packages/mount-batur-1.jpg',
                    'packages/mount-batur-2.jpg',
                    'packages/mount-batur-3.jpg',
                    'packages/mount-batur-4.jpg'
                ]),
                'video_url' => 'https://www.youtube.com/embed/batur-trekking',
                'commission_rate' => 15.00,
                'is_featured' => true,
                'status' => 'active',
                'seo_title' => 'Mount Batur Sunrise Trekking - Best Volcano Adventure in Bali',
                'seo_description' => 'Join our Mount Batur sunrise trekking adventure for spectacular volcano views, natural breakfast, and unforgettable memories in Bali.',
                'keywords' => 'mount batur, sunrise trekking, volcano tour, bali adventure, hiking bali',
                'created_by' => $admin->id,
            ],

            // Cultural Heritage Packages
            [
                'category_id' => $categories->where('slug', 'cultural-heritage')->first()?->id ?? 2,
                'name' => 'Royal Temples & Cultural Discovery Tour',
                'slug' => 'royal-temples-cultural-tour',
                'short_description' => 'Discover Bali\'s rich cultural heritage through ancient temples, traditional villages, and royal palaces',
                'full_description' => 'Immerse yourself in Bali\'s fascinating cultural tapestry with this comprehensive tour of the island\'s most significant temples and cultural sites. Visit the majestic Besakih Temple, known as the "Mother Temple" of Bali, explore the ancient royal court of Klungkung, and witness traditional life in authentic Balinese villages. This journey offers deep insights into Hindu-Balinese traditions, architecture, and daily life, guided by knowledgeable local experts who bring the rich history to life.',
                'highlights' => json_encode([
                    'Visit to Besakih Temple, the holiest temple in Bali',
                    'Explore Klungkung Royal Palace and Hall of Justice',
                    'Traditional village visit with cultural performance',
                    'Local artisan workshops (wood carving, silver making)',
                    'Traditional Balinese lunch with local family',
                    'Holy water blessing ceremony participation'
                ]),
                'includes' => json_encode([
                    'Hotel pickup and drop-off',
                    'Professional cultural guide',
                    'All entrance fees and donations',
                    'Traditional Balinese lunch',
                    'Mineral water and wet towels',
                    'Cultural performance tickets',
                    'Temple attire (sarong and sash)'
                ]),
                'excludes' => json_encode([
                    'Personal expenses',
                    'Additional food and drinks',
                    'Tips for guide and driver',
                    'Shopping purchases',
                    'Travel insurance'
                ]),
                'terms_conditions' => 'Modest dress required for temple visits. Respectful behavior expected at religious sites. Tour may be adjusted based on religious ceremonies.',
                'duration_days' => 1,
                'duration_nights' => 0,
                'price_adult' => 850000,
                'price_child' => 600000,
                'price_infant' => 0,
                'min_participants' => 1,
                'max_participants' => 15,
                'difficulty_level' => 'easy',
                'departure_city' => 'Denpasar/Ubud/Sanur',
                'meeting_point' => 'Hotel lobby',
                'transportation_details' => 'Air-conditioned minibus',
                'accommodation_details' => null,
                'main_image_path' => 'packages/cultural-heritage-tour.jpg',
                'gallery_images' => json_encode([
                    'packages/besakih-temple.jpg',
                    'packages/klungkung-palace.jpg',
                    'packages/traditional-village.jpg',
                    'packages/cultural-performance.jpg'
                ]),
                'commission_rate' => 12.00,
                'is_featured' => true,
                'status' => 'active',
                'seo_title' => 'Bali Cultural Heritage Tour - Temples, Palaces & Traditions',
                'seo_description' => 'Explore Bali\'s rich cultural heritage with visits to sacred temples, royal palaces, and traditional villages. Authentic cultural experience.',
                'keywords' => 'bali culture, temple tour, heritage tour, besakih temple, cultural experience',
                'created_by' => $admin->id,
            ],

            // Beach & Marine Packages
            [
                'category_id' => $categories->where('slug', 'beach-marine')->first()?->id ?? 3,
                'name' => 'Nusa Penida Island Paradise Day Trip',
                'slug' => 'nusa-penida-island-paradise',
                'short_description' => 'Explore the pristine beaches and dramatic cliffs of Nusa Penida island with snorkeling adventure',
                'full_description' => 'Escape to the untouched paradise of Nusa Penida, where dramatic limestone cliffs meet crystal-clear waters and pristine white sand beaches. This full-day adventure takes you to the island\'s most Instagram-worthy spots including Kelingking Beach, Angel\'s Billabong, and Broken Beach. Experience world-class snorkeling with colorful tropical fish and corals, enjoy a delicious seafood lunch with ocean views, and capture memories that will last a lifetime.',
                'highlights' => json_encode([
                    'Visit iconic Kelingking Beach with T-Rex cliff formation',
                    'Swimming and snorkeling at Crystal Bay',
                    'Explore Angel\'s Billabong natural infinity pool',
                    'Marvel at Broken Beach natural archway',
                    'Fast boat transfer with scenic ocean views',
                    'Professional snorkeling equipment provided'
                ]),
                'includes' => json_encode([
                    'Round-trip fast boat tickets',
                    'Hotel pickup and drop-off to harbor',
                    'Professional local guide',
                    'Snorkeling equipment (mask, fins, life jacket)',
                    'Fresh seafood lunch',
                    'Mineral water and tropical fruits',
                    'Life insurance during boat transfer'
                ]),
                'excludes' => json_encode([
                    'Underwater camera rental',
                    'Personal expenses',
                    'Tips for guide and boat crew',
                    'Additional food and beverages',
                    'Travel insurance'
                ]),
                'terms_conditions' => 'Weather dependent activity. Swimming ability required for snorkeling. Boat schedule subject to weather conditions.',
                'duration_days' => 1,
                'duration_nights' => 0,
                'price_adult' => 950000,
                'price_child' => 750000,
                'price_infant' => 200000,
                'min_participants' => 2,
                'max_participants' => 20,
                'difficulty_level' => 'easy',
                'departure_city' => 'Sanur Harbor',
                'meeting_point' => 'Sanur Beach Harbor',
                'transportation_details' => 'Fast boat and local transport on island',
                'accommodation_details' => null,
                'main_image_path' => 'packages/nusa-penida-paradise.jpg',
                'gallery_images' => json_encode([
                    'packages/kelingking-beach.jpg',
                    'packages/angels-billabong.jpg',
                    'packages/broken-beach.jpg',
                    'packages/crystal-bay.jpg'
                ]),
                'commission_rate' => 18.00,
                'is_featured' => true,
                'status' => 'active',
                'seo_title' => 'Nusa Penida Day Trip - Island Paradise & Snorkeling Adventure',
                'seo_description' => 'Discover Nusa Penida\'s stunning beaches, dramatic cliffs, and crystal-clear waters. Perfect day trip with snorkeling and sightseeing.',
                'keywords' => 'nusa penida, kelingking beach, day trip, snorkeling, island tour, bali islands',
                'created_by' => $admin->id,
            ],

            // Multi-day Experience
            [
                'category_id' => $categories->where('slug', 'multi-day-experiences')->first()?->id ?? 4,
                'name' => 'Ultimate Bali Cultural & Nature Discovery',
                'slug' => 'ultimate-bali-cultural-nature-discovery',
                'short_description' => '5 days exploring Bali\'s highlights: volcanoes, temples, rice terraces, beaches, and cultural immersion',
                'full_description' => 'Experience the very best of Bali with this carefully crafted 5-day journey that showcases the island\'s diverse landscapes, rich culture, and warm hospitality. From the volcanic landscapes of Mount Batur to the emerald rice terraces of Jatiluwih, from ancient temples to pristine beaches, this comprehensive tour offers an authentic taste of Balinese life. Stay in carefully selected accommodations that reflect local character while ensuring comfort and convenience.',
                'highlights' => json_encode([
                    'Mount Batur sunrise trekking with volcanic breakfast',
                    'Traditional cooking class with local family',
                    'Visit to UNESCO World Heritage rice terraces',
                    'Temple hopping including Tanah Lot and Uluwatu',
                    'Relaxation time at beautiful beaches',
                    'Traditional Kecak fire dance performance',
                    'Ubud art village and monkey forest exploration',
                    'Spa session with traditional Balinese massage'
                ]),
                'includes' => json_encode([
                    '4 nights accommodation (3-star hotels)',
                    'Daily breakfast and 3 lunches',
                    'All transportation in air-conditioned vehicle',
                    'Professional English-speaking guide',
                    'All entrance fees and activities',
                    'Cultural performance tickets',
                    'Airport pickup and drop-off',
                    'Mineral water during tours'
                ]),
                'excludes' => json_encode([
                    'International flights',
                    'Visa fees',
                    'Dinners (except mentioned)',
                    'Personal expenses',
                    'Tips for guide and driver',
                    'Travel insurance',
                    'Alcoholic beverages'
                ]),
                'terms_conditions' => 'Minimum 2 participants required. Single supplement available. Moderate walking required. Weather may affect some activities.',
                'duration_days' => 5,
                'duration_nights' => 4,
                'price_adult' => 4500000,
                'price_child' => 3500000,
                'price_infant' => 500000,
                'min_participants' => 2,
                'max_participants' => 12,
                'difficulty_level' => 'moderate',
                'departure_city' => 'Denpasar Airport',
                'meeting_point' => 'Ngurah Rai International Airport',
                'transportation_details' => 'Private air-conditioned vehicle with driver',
                'accommodation_details' => '3-star hotels with pool and breakfast, central locations',
                'main_image_path' => 'packages/ultimate-bali-discovery.jpg',
                'gallery_images' => json_encode([
                    'packages/batur-sunrise.jpg',
                    'packages/rice-terraces.jpg',
                    'packages/tanah-lot.jpg',
                    'packages/ubud-village.jpg',
                    'packages/kecak-dance.jpg'
                ]),
                'commission_rate' => 20.00,
                'is_featured' => true,
                'status' => 'active',
                'seo_title' => 'Ultimate Bali 5D4N Tour - Culture, Nature & Adventure Package',
                'seo_description' => 'Comprehensive 5-day Bali tour covering volcanoes, temples, rice terraces, beaches, and cultural experiences. Perfect for first-time visitors.',
                'keywords' => 'bali tour package, 5 day bali, cultural tour, nature tour, bali highlights, complete bali experience',
                'created_by' => $admin->id,
            ],

            // Wellness & Spa Packages
            [
                'category_id' => $categories->where('slug', 'wellness-spa')->first()?->id ?? 5,
                'name' => 'Balinese Healing & Wellness Retreat',
                'slug' => 'balinese-healing-wellness-retreat',
                'short_description' => 'Rejuvenate your body and soul with traditional Balinese healing treatments and wellness practices',
                'full_description' => 'Reconnect with your inner peace through this transformative wellness journey that combines ancient Balinese healing traditions with modern wellness practices. Experience the purifying ritual of melukat (water blessing), indulge in traditional herbal treatments, practice meditation in serene temple settings, and nourish your body with organic, locally-sourced cuisine. This retreat is designed to restore balance and harmony to your mind, body, and spirit.',
                'highlights' => json_encode([
                    'Traditional melukat water purification ceremony',
                    '90-minute Balinese royal treatment spa session',
                    'Guided meditation at sacred temple sites',
                    'Herbal consultation with traditional healer (Balian)',
                    'Organic farm-to-table lunch with healing foods',
                    'Yoga session overlooking rice fields',
                    'Take-home herbal remedy kit'
                ]),
                'includes' => json_encode([
                    'Hotel pickup and drop-off',
                    'Professional wellness guide',
                    'All spa treatments and therapies',
                    'Ceremony offerings and donations',
                    'Organic lunch with herbal drinks',
                    'Meditation and yoga instruction',
                    'Herbal remedy kit',
                    'Comfortable meditation cushions'
                ]),
                'excludes' => json_encode([
                    'Additional spa treatments',
                    'Personal expenses',
                    'Tips for therapists and guide',
                    'Shopping purchases',
                    'Additional food and beverages'
                ]),
                'terms_conditions' => 'Please inform of any allergies or medical conditions. Comfortable clothing recommended. Some activities weather dependent.',
                'duration_days' => 1,
                'duration_nights' => 0,
                'price_adult' => 1200000,
                'price_child' => 800000,
                'price_infant' => 0,
                'min_participants' => 1,
                'max_participants' => 8,
                'difficulty_level' => 'easy',
                'departure_city' => 'Ubud area',
                'meeting_point' => 'Hotel lobby',
                'transportation_details' => 'Air-conditioned vehicle',
                'accommodation_details' => null,
                'main_image_path' => 'packages/wellness-retreat.jpg',
                'gallery_images' => json_encode([
                    'packages/melukat-ceremony.jpg',
                    'packages/balinese-spa.jpg',
                    'packages/temple-meditation.jpg',
                    'packages/organic-lunch.jpg'
                ]),
                'commission_rate' => 16.00,
                'is_featured' => false,
                'status' => 'active',
                'seo_title' => 'Balinese Wellness Retreat - Traditional Healing & Spa Experience',
                'seo_description' => 'Experience authentic Balinese healing with water purification, traditional spa treatments, meditation, and herbal therapies.',
                'keywords' => 'bali wellness, traditional healing, spa retreat, melukat ceremony, balinese massage, meditation',
                'created_by' => $admin->id,
            ],

            // Family Fun Packages
            [
                'category_id' => $categories->where('slug', 'family-fun')->first()?->id ?? 6,
                'name' => 'Bali Family Adventure Safari',
                'slug' => 'bali-family-adventure-safari',
                'short_description' => 'Perfect family adventure combining safari park, water activities, and cultural experiences for all ages',
                'full_description' => 'Create unforgettable family memories with this action-packed day designed especially for families with children. Start your adventure at Bali Safari & Marine Park, where you\'ll encounter exotic animals from Indonesia and beyond in natural habitats. Continue with fun water activities at a beautiful beach, enjoy interactive cultural shows, and end the day with a delicious family dinner featuring both international and local cuisine that kids will love.',
                'highlights' => json_encode([
                    'Full access to Bali Safari & Marine Park',
                    'Safari journey with elephants, lions, and tigers',
                    'Interactive animal shows and feeding sessions',
                    'Beach time with safe swimming area for kids',
                    'Cultural dance performance with audience participation',
                    'Kid-friendly restaurant with playground',
                    'Photo opportunities with friendly animals'
                ]),
                'includes' => json_encode([
                    'Hotel pickup and drop-off',
                    'Safari park entrance tickets',
                    'All animal shows and activities',
                    'Beach access and facilities',
                    'Family lunch at kid-friendly restaurant',
                    'Cultural performance tickets',
                    'Professional guide experienced with families',
                    'First aid kit and safety equipment'
                ]),
                'excludes' => json_encode([
                    'Additional food and drinks',
                    'Souvenir purchases',
                    'Photography packages',
                    'Tips for guide and driver',
                    'Travel insurance'
                ]),
                'terms_conditions' => 'Children must be accompanied by adults at all times. Height restrictions apply to some activities. Activity schedule may vary.',
                'duration_days' => 1,
                'duration_nights' => 0,
                'price_adult' => 800000,
                'price_child' => 600000,
                'price_infant' => 100000,
                'min_participants' => 2,
                'max_participants' => 20,
                'difficulty_level' => 'easy',
                'departure_city' => 'Denpasar/Sanur/Nusa Dua',
                'meeting_point' => 'Hotel lobby',
                'transportation_details' => 'Family-friendly air-conditioned vehicle with safety seats',
                'accommodation_details' => null,
                'main_image_path' => 'packages/family-safari-adventure.jpg',
                'gallery_images' => json_encode([
                    'packages/safari-park.jpg',
                    'packages/elephant-show.jpg',
                    'packages/family-beach.jpg',
                    'packages/cultural-dance.jpg'
                ]),
                'commission_rate' => 14.00,
                'is_featured' => false,
                'status' => 'active',
                'seo_title' => 'Bali Family Safari Adventure - Perfect Day Trip for Kids',
                'seo_description' => 'Family-friendly Bali adventure with safari park, beach activities, and cultural shows. Perfect for children of all ages.',
                'keywords' => 'bali family tour, safari park, family activities, kids tour bali, family fun bali',
                'created_by' => $admin->id,
            ]
        ];

        foreach ($packages as $packageData) {
            TravelPackage::create($packageData);
        }

        $this->command->info('Travel packages seeded successfully!');
    }
}
