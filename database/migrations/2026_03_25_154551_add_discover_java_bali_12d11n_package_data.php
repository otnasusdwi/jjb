<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $slug = 'discover-java-bali-overland-12d11n';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('travel_packages')) {
            return;
        }

        DB::transaction(function (): void {
            $now = now();

            $packageData = [
                'name' => '12D11N Discover Java Bali by Overland',
                'slug' => $this->slug,
                'category' => 'adventure',
                'location' => 'Yogyakarta - Bromo - Ijen - Ubud - South Bali',
                'duration_days' => 12,
                'duration_nights' => 11,
                'currency' => 'IDR',
                'price' => 25980000,
                'child_price' => null,
                'featured_image' => null,
                'gallery_images' => null,
                'description' => 'Experience the cultural and natural highlights of Java and Bali on one immersive overland journey. Visit Borobudur and Prambanan temples, explore the Java heritage of Kotagede, and witness spectacular sunrise moments at Mount Bromo and Ijen crater. Continue by ferry to Bali for Ubud art, spiritual temples, rice field walks, waterfalls, and South Bali highlights including Uluwatu Temple, Kecak Dance at sunset, and Jimbaran beach seafood dinner. End the package with a flexible optional day for watersport or Nusa Penida excursion.',
                'max_participants' => 10,
                'status' => 'active',
                'keywords' => 'java bali overland, yogyakarta, borobudur, prambanan, bromo, ijen, ubud, uluwatu, 12d11n',
                'meta_title' => '12D11N Discover Java Bali by Overland',
                'meta_description' => '12 days 11 nights overland package from Yogyakarta to Bali with Borobudur, Prambanan, Bromo sunrise, Ijen blue fire, Ubud highlights, and Uluwatu sunset show.',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $packageData = $this->filterColumns('travel_packages', $packageData);

            $packageId = DB::table('travel_packages')
                ->where('slug', $this->slug)
                ->value('id');

            if ($packageId) {
                unset($packageData['created_at']);
                DB::table('travel_packages')->where('id', $packageId)->update($packageData);
                $packageId = (int) $packageId;
            } else {
                $packageId = (int) DB::table('travel_packages')->insertGetId($packageData);
            }

            $this->clearPackageRelations($packageId);

            $itineraryDays = [
                [
                    'day_number' => 1,
                    'day_title' => 'TRANSFER IN',
                    'description' => 'Meals: Dinner',
                    'items' => [
                        'Arrival at YIA Airport and meet the tour guide',
                        'Hotel check in and short tour briefing',
                        'Dinner at hotel',
                        'Free time',
                    ],
                ],
                [
                    'day_number' => 2,
                    'day_title' => 'CITY CENTER',
                    'description' => 'Meals: Breakfast, Lunch, Dinner',
                    'items' => [
                        'Visit The Palace and Tamansari Castle inside the royal walls',
                        'Lunch at local restaurant',
                        'Becak ride to Sonobudoyo Museum',
                        'Optional photo in traditional Javanese outfit',
                        'Dinner at local restaurant',
                    ],
                ],
                [
                    'day_number' => 3,
                    'day_title' => 'KOTAGEDE',
                    'description' => 'Meals: Breakfast, Lunch, Dinner',
                    'items' => [
                        'Kotagede walking tour through heritage alleys and Kings tomb',
                        'Visit Kotagede Museum',
                        'Lunch at local restaurant',
                        'Silver craft visit and batik short course',
                        'Dinner at local restaurant',
                    ],
                ],
                [
                    'day_number' => 4,
                    'day_title' => 'NORTHWEST SIDE',
                    'description' => 'Meals: Breakfast, Lunch, Dinner',
                    'items' => [
                        'Borobudur temple structure visit',
                        'Lunch at local restaurant',
                        'VW Safari around Borobudur area or traditional Java gamelan short course',
                        'Dinner at local restaurant',
                    ],
                ],
                [
                    'day_number' => 5,
                    'day_title' => 'EAST SIDE',
                    'description' => 'Meals: Breakfast, Dinner',
                    'items' => [
                        'Check out from Yogyakarta hotel',
                        'Prambanan temple complex sightseeing',
                        'Road trip to Bromo area around 5-6 hours',
                        'Check in hotel near Mount Bromo',
                        'Dinner at hotel',
                    ],
                ],
                [
                    'day_number' => 6,
                    'day_title' => 'BROMO - IJEN',
                    'description' => 'Meals: Breakfast, Dinner',
                    'items' => [
                        'Early 4WD jeep to Penanjakan for Bromo sunrise view',
                        'Explore Sea of Sand and climb to Bromo crater rim',
                        'Return to hotel for breakfast, clean up, and check out',
                        'Road trip to Banyuwangi Ijen area around 6-7 hours',
                        'Check in hotel near Ijen and dinner at hotel',
                    ],
                ],
                [
                    'day_number' => 7,
                    'day_title' => 'IJEN - BALI',
                    'description' => 'Meals: Breakfast',
                    'items' => [
                        'Midnight transfer to Paltuding and Ijen safety briefing',
                        'Ijen trekking for blue fire and sunrise',
                        'Return to hotel for breakfast, rest, and check out',
                        'Transfer to Ketapang Harbor and ferry crossing to Gilimanuk',
                        'Overland drive to Ubud and guide handover Java to Bali',
                        'Free time in Ubud',
                    ],
                ],
                [
                    'day_number' => 8,
                    'day_title' => 'UBUD WALKING TOUR',
                    'description' => 'Meals: Dinner',
                    'items' => [
                        'Ubud Art Market, Ubud Palace, and Saraswati Temple',
                        'Sacred Monkey Forest Sanctuary visit',
                        'Juwuk Manis rice field walk',
                        'Campuhan Ridge Walk for sunset view',
                        'Dinner at local restaurant',
                    ],
                ],
                [
                    'day_number' => 9,
                    'day_title' => 'TEMPLE AND NATURE DAY',
                    'description' => 'Meals: Dinner',
                    'items' => [
                        'Spiritual purification at Tirta Empul Temple',
                        'Visit Gunung Kawi Temple',
                        'Coffee plantation experience',
                        'Kanto Lampo waterfall visit',
                        'Dinner at local restaurant',
                    ],
                ],
                [
                    'day_number' => 10,
                    'day_title' => 'SOUTH BALI',
                    'description' => 'Meals: Dinner',
                    'items' => [
                        'Check out Ubud hotel and transfer to Jimbaran or Sanur side',
                        'GWK and Uluwatu temple tour',
                        'Uluwatu Kecak Dance performance at sunset',
                        'Dinner at Jimbaran or Kedonganan beach',
                        'Check in hotel in South Bali area',
                    ],
                ],
                [
                    'day_number' => 11,
                    'day_title' => 'OPTIONAL EXPERIENCE DAY',
                    'description' => 'Meals: -',
                    'items' => [
                        'Optional watersport activities at Tanjung Benoa Nusa Dua',
                        'Optional full day Nusa Penida trip to Kelingking, Angel Billabong, and Crystal Bay',
                        'Alternative custom destination by request',
                    ],
                ],
                [
                    'day_number' => 12,
                    'day_title' => 'END OF PACKAGE',
                    'description' => 'Meals: -',
                    'items' => [
                        'Free program',
                        'End of service and additional arrangement on request',
                    ],
                ],
            ];

            $this->insertItinerary($packageId, $itineraryDays, $now);

            $inclusions = [
                'All entrance tickets and admissions',
                'Daily breakfast at the hotel',
                '3 x lunch',
                '9 x dinner',
                'Daily mineral water',
                'Yogyakarta accommodations: 4-star or 5-star Melia Purosani / Hyatt Regency / Kimaya / Loman Park / equal',
                'Bromo accommodation: 4-star Jiwa Jawa Bromo or equal',
                'Ijen accommodation: 4-star Jiwa Jawa Ijen or equal',
                'Bali accommodations: 5-star The Ubud Village Resort & Spa / Intercontinental Jimbaran / equal',
                'Private tour guide (English speaking, available only for 6 pax up)',
                'Transport: local van or medium tourist bus',
            ];

            $exclusions = [
                'Any return flight',
                'Visa and taxes',
                'Local guide fee',
                'Insurance',
                'Any personal expenses',
                'Tipping',
            ];

            $this->insertDescriptionList('package_inclusions', $packageId, $inclusions, $now);
            $this->insertDescriptionList('package_exclusions', $packageId, $exclusions, $now);

            $this->attachTags(
                $packageId,
                ['java', 'bali', 'long-trip', 'overland', 'culture', 'adventure'],
                $now
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('travel_packages')) {
            return;
        }

        DB::transaction(function (): void {
            $packageId = DB::table('travel_packages')
                ->where('slug', $this->slug)
                ->value('id');

            if (!$packageId) {
                return;
            }

            $packageId = (int) $packageId;

            if (Schema::hasTable('package_tag')) {
                DB::table('package_tag')->where('travel_package_id', $packageId)->delete();
            }

            if (Schema::hasTable('package_itineraries')) {
                if (Schema::hasTable('package_itinerary_items')) {
                    $itineraryIds = DB::table('package_itineraries')
                        ->where('travel_package_id', $packageId)
                        ->pluck('id');

                    if ($itineraryIds->isNotEmpty()) {
                        DB::table('package_itinerary_items')
                            ->whereIn('package_itinerary_id', $itineraryIds)
                            ->delete();
                    }
                }

                DB::table('package_itineraries')->where('travel_package_id', $packageId)->delete();
            }

            if (Schema::hasTable('package_inclusions')) {
                DB::table('package_inclusions')->where('travel_package_id', $packageId)->delete();
            }

            if (Schema::hasTable('package_exclusions')) {
                DB::table('package_exclusions')->where('travel_package_id', $packageId)->delete();
            }

            if (Schema::hasTable('package_galleries')) {
                DB::table('package_galleries')->where('travel_package_id', $packageId)->delete();
            }

            DB::table('travel_packages')->where('id', $packageId)->delete();
        });
    }

    private function clearPackageRelations(int $packageId): void
    {
        if (Schema::hasTable('package_tag')) {
            DB::table('package_tag')->where('travel_package_id', $packageId)->delete();
        }

        if (Schema::hasTable('package_itineraries')) {
            if (Schema::hasTable('package_itinerary_items')) {
                $itineraryIds = DB::table('package_itineraries')
                    ->where('travel_package_id', $packageId)
                    ->pluck('id');

                if ($itineraryIds->isNotEmpty()) {
                    DB::table('package_itinerary_items')
                        ->whereIn('package_itinerary_id', $itineraryIds)
                        ->delete();
                }
            }

            DB::table('package_itineraries')->where('travel_package_id', $packageId)->delete();
        }

        if (Schema::hasTable('package_inclusions')) {
            DB::table('package_inclusions')->where('travel_package_id', $packageId)->delete();
        }

        if (Schema::hasTable('package_exclusions')) {
            DB::table('package_exclusions')->where('travel_package_id', $packageId)->delete();
        }

        if (Schema::hasTable('package_galleries')) {
            DB::table('package_galleries')->where('travel_package_id', $packageId)->delete();
        }
    }

    private function insertItinerary(int $packageId, array $days, \DateTimeInterface $now): void
    {
        if (!Schema::hasTable('package_itineraries')) {
            return;
        }

        $hasItemsTable = Schema::hasTable('package_itinerary_items');
        $hasLegacyTitleColumn = Schema::hasColumn('package_itineraries', 'title');

        foreach ($days as $day) {
            $baseDayPayload = $this->filterColumns('package_itineraries', [
                'travel_package_id' => $packageId,
                'day_number' => $day['day_number'],
                'day_title' => $day['day_title'],
                'description' => $day['description'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if ($hasItemsTable && !$hasLegacyTitleColumn) {
                $itineraryId = DB::table('package_itineraries')->insertGetId($baseDayPayload);

                $order = 0;
                foreach ($day['items'] as $itemTitle) {
                    $itemPayload = $this->filterColumns('package_itinerary_items', [
                        'package_itinerary_id' => $itineraryId,
                        'title' => $itemTitle,
                        'order' => $order++,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    if (!empty($itemPayload)) {
                        DB::table('package_itinerary_items')->insert($itemPayload);
                    }
                }

                continue;
            }

            if ($hasLegacyTitleColumn) {
                $order = 0;
                foreach ($day['items'] as $itemTitle) {
                    $legacyPayload = $this->filterColumns('package_itineraries', array_merge($baseDayPayload, [
                        'title' => $itemTitle,
                        'order' => $order++,
                    ]));

                    if (!empty($legacyPayload)) {
                        DB::table('package_itineraries')->insert($legacyPayload);
                    }
                }

                continue;
            }

            if (!empty($baseDayPayload)) {
                DB::table('package_itineraries')->insert($baseDayPayload);
            }
        }
    }

    private function insertDescriptionList(string $table, int $packageId, array $rows, \DateTimeInterface $now): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $order = 0;

        foreach ($rows as $description) {
            $payload = $this->filterColumns($table, [
                'travel_package_id' => $packageId,
                'description' => $description,
                'order' => $order++,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if (!empty($payload)) {
                DB::table($table)->insert($payload);
            }
        }
    }

    private function attachTags(int $packageId, array $tagSlugs, \DateTimeInterface $now): void
    {
        if (!Schema::hasTable('tags') || !Schema::hasTable('package_tag')) {
            return;
        }

        $tagIds = DB::table('tags')
            ->whereIn('slug', $tagSlugs)
            ->pluck('id')
            ->all();

        foreach ($tagIds as $tagId) {
            $payload = $this->filterColumns('package_tag', [
                'travel_package_id' => $packageId,
                'tag_id' => $tagId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if (!empty($payload)) {
                DB::table('package_tag')->insertOrIgnore($payload);
            }
        }
    }

    private function filterColumns(string $table, array $data): array
    {
        $filtered = [];

        foreach ($data as $column => $value) {
            if (Schema::hasColumn($table, $column)) {
                $filtered[$column] = $value;
            }
        }

        return $filtered;
    }
};
