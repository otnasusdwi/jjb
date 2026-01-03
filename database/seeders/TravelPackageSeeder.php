<?php

namespace Database\Seeders;

use App\Models\PackageExclusion;
use App\Models\PackageGallery;
use App\Models\PackageInclusion;
use App\Models\PackageItinerary;
use App\Models\Tag;
use App\Models\TravelPackage;
use Illuminate\Database\Seeder;

class TravelPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch existing tags from database and build map by slug
        $tags = Tag::all();
        $tagMap = [];
        foreach ($tags as $tag) {
            $tagMap[$tag->slug] = $tag->id;
        }

        $packages = [
            // JAVA PACKAGES (2)
            [
                'name' => 'Yogyakarta Heritage & Culture 3D2N',
                'slug' => 'yogyakarta-heritage-culture-3d2n',
                'category' => 'culture',
                'description' => 'Jelajahi warisan budaya Yogyakarta dengan mengunjungi Borobudur, Prambanan, Keraton, dan Malioboro. Nikmati kuliner khas Jogja dan seni tradisional.',
                'location' => 'Yogyakarta',
                'duration_days' => 3,
                'duration_nights' => 2,
                'max_participants' => 15,
                'currency' => 'USD',
                'price' => 165,
                'child_price' => 120,
                'featured_image' => 'packages/yogyakarta-culture.jpg',
                'status' => 'active',
                'keywords' => 'yogyakarta, borobudur, prambanan, jogja, culture',
                'tag_slugs' => ['java', 'culture', 'heritage', 'family'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Penjemputan Bandara/Stasiun', 'description' => 'Dijemput dari Bandara Adisucipto atau Stasiun Tugu Yogyakarta dan check-in hotel.'],
                        ['title' => 'Keraton Yogyakarta', 'description' => 'Kunjungi istana Sultan dengan arsitektur Jawa klasik. Lihat koleksi pusaka kerajaan dan museum.'],
                        ['title' => 'Taman Sari Water Castle', 'description' => 'Bekas taman istana dengan kolam pemandian dan terowongan bawah tanah yang eksotis.'],
                        ['title' => 'Malioboro Shopping', 'description' => 'Belanja oleh-oleh khas Jogja di jantung kota. Batik, kerajinan, dan kuliner khas.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Candi Borobudur Sunrise', 'description' => 'Berangkat pagi untuk menyaksikan sunrise di Borobudur, candi Buddha terbesar di dunia (UNESCO).'],
                        ['title' => 'Punthuk Setumbu', 'description' => 'View point terbaik untuk foto Borobudur dari kejauhan dengan background Gunung Merapi.'],
                        ['title' => 'Candi Prambanan', 'description' => 'Kunjungi kompleks candi Hindu termegah dengan reliefnya yang indah (UNESCO).'],
                        ['title' => 'Sunset di Ratu Boko', 'description' => 'Nikmati sunset dari kompleks Istana Ratu Boko dengan pemandangan Prambanan.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Kaliurang Highland', 'description' => 'Kawasan sejuk di lereng Merapi dengan udara segar dan view pegunungan.'],
                        ['title' => 'Museum Ullen Sentalu', 'description' => 'Museum seni dan budaya Jawa dengan koleksi batik dan pusaka keraton.'],
                        ['title' => 'Shopping Terakhir', 'description' => 'Belanja oleh-oleh tambahan di pusat kota sebelum transfer ke bandara.'],
                        ['title' => 'Transfer Bandara/Stasiun', 'description' => 'Antar ke bandara atau stasiun untuk perjalanan pulang.'],
                    ]],
                ],
                'inclusions' => [
                    'Hotel 2 malam dengan sarapan (3-star)',
                    'Transportasi mobil ber-AC selama tour',
                    'Guide berbahasa Indonesia',
                    'Tiket masuk semua objek wisata',
                    'Parkir dan biaya tol',
                    'Air mineral selama tour',
                ],
                'exclusions' => [
                    'Tiket pesawat/kereta api',
                    'Makan siang dan malam',
                    'Pengeluaran pribadi',
                    'Tips guide dan driver',
                    'Asuransi perjalanan',
                ],
            ],
            [
                'name' => 'Bromo Ijen Crater Adventure 4D3N',
                'slug' => 'bromo-ijen-crater-adventure-4d3n',
                'category' => 'adventure',
                'description' => 'Petualangan menakjubkan ke Gunung Bromo dan Kawah Ijen. Saksikan blue fire fenomena alam langka dan sunrise spektakuler di Bromo.',
                'location' => 'Surabaya - Bromo - Ijen',
                'duration_days' => 4,
                'duration_nights' => 3,
                'max_participants' => 12,
                'currency' => 'USD',
                'price' => 250,
                'child_price' => 190,
                'featured_image' => 'packages/bromo-ijen.jpg',
                'status' => 'active',
                'keywords' => 'bromo, ijen, blue fire, sunrise, volcano, adventure',
                'tag_slugs' => ['java', 'adventure', 'volcano', 'trekking'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Arrival Surabaya', 'description' => 'Penjemputan di Bandara Juanda Surabaya dan perjalanan menuju Bromo (4-5 jam).'],
                        ['title' => 'Check-in Hotel Bromo', 'description' => 'Check-in hotel di sekitar Bromo dan istirahat untuk persiapan sunrise tour besok.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Bromo Sunrise Tour (03:00)', 'description' => 'Berangkat dini hari ke Penanjakan viewpoint untuk sunrise terbaik di Bromo.'],
                        ['title' => 'Explore Bromo Crater', 'description' => 'Naik jeep melintasi lautan pasir dan trekking ke kawah Bromo yang masih aktif.'],
                        ['title' => 'Savanna & Teletubbies Hill', 'description' => 'Foto di savanna luas dan bukit Teletubbies yang hijau dan bergelombang.'],
                        ['title' => 'Perjalanan ke Banyuwangi', 'description' => 'Perjalanan panjang 7-8 jam menuju Banyuwangi untuk tour Ijen besok.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Ijen Blue Fire Trek (00:00)', 'description' => 'Trekking malam ke Kawah Ijen untuk melihat blue fire phenomenon yang langka!'],
                        ['title' => 'Ijen Sunrise & Crater', 'description' => 'Saksikan sunrise di kawah dengan danau asam berwarna tosca yang cantik.'],
                        ['title' => 'Traditional Sulfur Miners', 'description' => 'Lihat para penambang belerang tradisional dengan beban berat (dokumentasi sosial).'],
                        ['title' => 'Return to Hotel', 'description' => 'Kembali ke hotel untuk sarapan, istirahat, dan check-out.'],
                    ]],
                    ['day' => 4, 'items' => [
                        ['title' => 'Transfer Banyuwangi', 'description' => 'Perjalanan ke Pelabuhan Ketapang atau Bandara Banyuwangi.'],
                        ['title' => 'Optional Ferry to Bali', 'description' => 'Bisa lanjut ke Bali dengan ferry atau penerbangan pulang dari Banyuwangi.'],
                    ]],
                ],
                'inclusions' => [
                    'Hotel 3 malam (2x Bromo area, 1x Banyuwangi)',
                    'Bromo Jeep 4WD untuk sunrise tour',
                    'Guide profesional Bromo & Ijen',
                    'Masker gas untuk Ijen blue fire',
                    'Tiket masuk Bromo & Ijen',
                    'Transportasi Surabaya-Bromo-Ijen-Banyuwangi',
                ],
                'exclusions' => [
                    'Tiket pesawat/kereta',
                    'Makanan selain breakfast',
                    'Porter di Ijen (opsional)',
                    'Tips guide dan driver',
                    'Pengeluaran pribadi',
                ],
            ],

            // BALI PACKAGES (2)
            [
                'name' => 'Bali Paradise 4D3N - Beach & Culture',
                'slug' => 'bali-paradise-4d3n-beach-culture',
                'category' => 'beach',
                'description' => 'Kombinasi sempurna pantai-pantai cantik Bali dan budaya tradisional. Mengunjungi Uluwatu, Tanah Lot, Ubud, dan pantai-pantai eksotis Nusa Dua.',
                'location' => 'Bali',
                'duration_days' => 4,
                'duration_nights' => 3,
                'max_participants' => 20,
                'currency' => 'USD',
                'price' => 210,
                'child_price' => 160,
                'featured_image' => 'packages/bali-paradise.jpg',
                'status' => 'active',
                'keywords' => 'bali, beach, uluwatu, tanah lot, ubud, culture',
                'tag_slugs' => ['bali', 'beach', 'culture', 'family'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Arrival Ngurah Rai Airport', 'description' => 'Penjemputan di bandara dan check-in hotel di area Kuta atau Seminyak.'],
                        ['title' => 'Pantai Kuta Sunset', 'description' => 'Bersantai di Pantai Kuta, pantai paling terkenal di Bali dengan sunset cantik.'],
                        ['title' => 'Beachwalk Mall', 'description' => 'Shopping dan dinner di mall tepi pantai dengan view laut yang indah.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'GWK Cultural Park', 'description' => 'Kunjungi patung Garuda Wisnu Kencana raksasa setinggi 121 meter dan teater budaya.'],
                        ['title' => 'Pantai Pandawa', 'description' => 'Pantai tersembunyi dengan tebing kapur putih dan air laut jernih untuk berenang.'],
                        ['title' => 'Uluwatu Temple', 'description' => 'Pura di atas tebing 70 meter dengan pemandangan samudra Hindia yang dramatis.'],
                        ['title' => 'Kecak Fire Dance', 'description' => 'Pertunjukan tari Kecak sunset dengan 50+ penari di Amphitheater Uluwatu.'],
                        ['title' => 'Jimbaran Seafood Dinner', 'description' => 'Makan malam seafood bakar di tepi pantai Jimbaran dengan kaki di pasir.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Tegallalang Rice Terrace', 'description' => 'Sawah bertingkat ikonik Ubud dengan ayunan di atas jurang (Instagram spot!).'],
                        ['title' => 'Tirta Empul Holy Spring', 'description' => 'Pura dengan sumber air suci untuk ritual melukat (pembersihan spiritual).'],
                        ['title' => 'Ubud Monkey Forest', 'description' => 'Hutan suci dengan ratusan monyet jinak dan pura-pura kuno yang mistis.'],
                        ['title' => 'Ubud Art Market', 'description' => 'Pasar seni tradisional dengan kerajinan, lukisan, dan souvenir khas Bali.'],
                        ['title' => 'Ubud Royal Palace', 'description' => 'Istana kerajaan Ubud dengan arsitektur Bali klasik yang masih difungsikan.'],
                    ]],
                    ['day' => 4, 'items' => [
                        ['title' => 'Tanah Lot Temple', 'description' => 'Pura ikonik di atas batu karang di tengah laut, terkenal dengan sunset-nya.'],
                        ['title' => 'Taman Ayun Royal Temple', 'description' => 'Kompleks pura kerajaan dengan taman yang indah dan kolam teratai (UNESCO).'],
                        ['title' => 'Shopping & Transfer Airport', 'description' => 'Belanja oleh-oleh terakhir dan transfer ke bandara untuk penerbangan pulang.'],
                    ]],
                ],
                'inclusions' => [
                    'Hotel 3 malam dengan breakfast',
                    'Transportasi AC dengan driver',
                    'Tiket masuk semua destinasi',
                    'Kecak Dance Uluwatu',
                    '1x Seafood dinner Jimbaran',
                    'Guide berbahasa Indonesia',
                ],
                'exclusions' => [
                    'Tiket pesawat',
                    'Makan (selain mentioned)',
                    'Tips guide/driver',
                    'Aktivitas opsional',
                    'Travel insurance',
                ],
            ],
            [
                'name' => 'Nusa Penida & Nusa Lembongan Island 3D2N',
                'slug' => 'nusa-penida-lembongan-island-3d2n',
                'category' => 'beach',
                'description' => 'Eksplorasi pulau-pulau kecil di sekitar Bali dengan pantai eksotis dan tebing dramatis. Kelingking Beach, Angel Billabong, dan snorkeling spots terbaik.',
                'location' => 'Nusa Penida & Nusa Lembongan',
                'duration_days' => 3,
                'duration_nights' => 2,
                'max_participants' => 16,
                'currency' => 'USD',
                'price' => 190,
                'child_price' => 145,
                'featured_image' => 'packages/nusa-islands.jpg',
                'status' => 'active',
                'keywords' => 'nusa penida, nusa lembongan, kelingkling, crystal bay, snorkeling',
                'tag_slugs' => ['bali', 'beach', 'island-hopping', 'snorkeling'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Sanur Harbor Departure', 'description' => 'Berangkat dari Pelabuhan Sanur dengan fast boat menuju Nusa Penida (45 menit).'],
                        ['title' => 'Kelingking Beach (T-Rex)', 'description' => 'Spot foto paling iconic dengan tebing berbentuk T-Rex dan pantai di bawahnya.'],
                        ['title' => 'Angel Billabong', 'description' => 'Natural infinity pool dengan air laut jernih (bisa berenang saat kondisi aman).'],
                        ['title' => 'Broken Beach', 'description' => 'Jembatan batu alami dengan archway ke laguna biru yang spektakuler.'],
                        ['title' => 'Check-in Hotel Nusa Penida', 'description' => 'Check-in hotel dan free time untuk explore sekitar atau istirahat.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Crystal Bay Snorkeling', 'description' => 'Snorkeling di Crystal Bay dengan visibility terbaik, terumbu karang dan ikan tropis.'],
                        ['title' => 'Atuh Beach', 'description' => 'Pantai tersembunyi dengan formasi batu karang unik dan pasir putih bersih.'],
                        ['title' => 'Diamond Beach', 'description' => 'Pantai dengan tangga di tebing putih, pemandangan paling instagramable!'],
                        ['title' => 'Boat to Nusa Lembongan', 'description' => 'Pindah ke Nusa Lembongan dengan boat lokal dan check-in hotel.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Mangrove Forest Tour', 'description' => 'Jelajahi hutan mangrove dengan kayak atau stand-up paddle (optional).'],
                        ['title' => 'Dream Beach', 'description' => 'Pantai cantik dengan cliff dan ombak untuk surfing (beach club tersedia).'],
                        ['title' => 'Devil\'s Tear', 'description' => 'Ombak besar menghantam tebing karang, semburan air spektakuler saat high tide.'],
                        ['title' => 'Yellow Bridge', 'description' => 'Jembatan kuning ikonik penghubung Nusa Lembongan dan Ceningan.'],
                        ['title' => 'Return to Bali', 'description' => 'Fast boat kembali ke Sanur dan transfer ke hotel/airport.'],
                    ]],
                ],
                'inclusions' => [
                    'Return fast boat tickets',
                    'Hotel 2 malam (Penida & Lembongan)',
                    'Transportasi mobil/motor di pulau',
                    'Snorkeling equipment',
                    'Local guide',
                    'Tiket masuk objek wisata',
                ],
                'exclusions' => [
                    'Bali hotel pickup (extra charge)',
                    'Makanan',
                    'Trekking turun Kelingking (optional)',
                    'Kayak/SUP rental',
                    'Tips guide',
                ],
            ],

            // LOMBOK PACKAGES (2)
            [
                'name' => 'Lombok Gili Islands Paradise 4D3N',
                'slug' => 'lombok-gili-islands-paradise-4d3n',
                'category' => 'beach',
                'description' => 'Surga tropis Lombok dan Gili Trawangan. Snorkeling dengan penyu, pantai pasir putih, dan sunset party. Kunjungi air terjun dan pantai pink yang eksotis.',
                'location' => 'Lombok & Gili Trawangan',
                'duration_days' => 4,
                'duration_nights' => 3,
                'max_participants' => 18,
                'currency' => 'USD',
                'price' => 230,
                'child_price' => 170,
                'featured_image' => 'packages/lombok-gili.jpg',
                'status' => 'active',
                'keywords' => 'lombok, gili trawangan, snorkeling, turtle, pink beach, waterfall',
                'tag_slugs' => ['lombok', 'beach', 'island-hopping', 'snorkeling'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Arrival Lombok Airport', 'description' => 'Dijemput di Bandara Internasional Lombok dan perjalanan ke Senggigi.'],
                        ['title' => 'Senggigi Beach', 'description' => 'Bersantai di pantai Senggigi dengan sunset view dan jajanan local.'],
                        ['title' => 'Check-in Hotel Senggigi', 'description' => 'Check-in hotel di Senggigi beach area untuk 1 malam.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Tiu Kelep Waterfall', 'description' => 'Trekking 45 menit ke air terjun Tiu Kelep yang megah dengan kolam alami segar.'],
                        ['title' => 'Sendang Gile Waterfall', 'description' => 'Air terjun kedua yang lebih mudah dijangkau dengan pemandangan indah.'],
                        ['title' => 'Traditional Sasak Village', 'description' => 'Kunjungi desa tradisional Sasak dengan rumah-rumah unik dari bambu dan tanah.'],
                        ['title' => 'Boat to Gili Trawangan', 'description' => 'Naik public boat atau private speedboat ke Gili Trawangan (1.5 jam).'],
                        ['title' => 'Check-in Gili Hotel', 'description' => 'Check-in hotel di Gili T, pulau tanpa kendaraan bermotor!'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Gili 3 Islands Snorkeling', 'description' => 'Island hopping ke Gili Meno dan Gili Air dengan snorkeling di 6+ spots.'],
                        ['title' => 'Turtle Point Snorkeling', 'description' => 'Berenang dan foto dengan penyu hijau yang jinak di habitat alaminya!'],
                        ['title' => 'Statue Underwater', 'description' => 'Snorkeling ke underwater sculpture garden (patung-patung bawah laut).'],
                        ['title' => 'Gili T Beach Sunset', 'description' => 'Menikmati sunset di Gili T dengan swing di pantai yang iconic.'],
                        ['title' => 'Night Life (Optional)', 'description' => 'Gili T terkenal dengan party scene dan beach clubs hingga malam.'],
                    ]],
                    ['day' => 4, 'items' => [
                        ['title' => 'Boat to Lombok', 'description' => 'Kembali ke Lombok mainland dengan public boat pagi.'],
                        ['title' => 'Pink Beach Lombok', 'description' => 'Kunjungi Pantai Tangsi (Pink Beach) dengan pasir berwarna merah muda unik.'],
                        ['title' => 'Shopping Oleh-oleh', 'description' => 'Belanja kerajinan khas Lombok seperti mutiara, tenun, dan keramik.'],
                        ['title' => 'Transfer Airport', 'description' => 'Antar ke bandara untuk penerbangan pulang.'],
                    ]],
                ],
                'inclusions' => [
                    'Hotel 3 malam (1 Senggigi, 2 Gili T)',
                    'Boat tickets to/from Gili',
                    'Gili 3 island hopping tour',
                    'Snorkeling equipment & guide',
                    'Transportasi Lombok',
                    'Tiket masuk objek wisata',
                ],
                'exclusions' => [
                    'Tiket pesawat',
                    'Makanan',
                    'Bicycle/Cidomo rental di Gili',
                    'Aktivitas water sports',
                    'Tips guide',
                ],
            ],
            [
                'name' => 'Mount Rinjani Trekking 3D2N',
                'slug' => 'mount-rinjani-trekking-3d2n',
                'category' => 'adventure',
                'description' => 'Pendakian ke Gunung Rinjani (3.726 mdpl), gunung tertinggi kedua di Indonesia. Danau Segara Anak, hot spring, dan sunrise dari puncak yang menakjubkan.',
                'location' => 'Lombok - Gunung Rinjani',
                'duration_days' => 3,
                'duration_nights' => 2,
                'max_participants' => 10,
                'currency' => 'USD',
                'price' => 180,
                'child_price' => null,
                'featured_image' => 'packages/rinjani-trek.jpg',
                'status' => 'active',
                'keywords' => 'rinjani, trekking, hiking, volcano, lombok, adventure',
                'tag_slugs' => ['lombok', 'adventure', 'trekking', 'volcano'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Pickup & Registration', 'description' => 'Dijemput jam 06:00 dan registrasi di Sembalun village (1.156 mdpl).'],
                        ['title' => 'Trekking Start - Pos 1', 'description' => 'Mulai pendakian melewati savanna dan hutan dengan pemandangan indah (3 jam).'],
                        ['title' => 'Lunch at Pos 2', 'description' => 'Istirahat dan makan siang di Pos 2 yang sudah disiapkan porter.'],
                        ['title' => 'Continue to Sembalun Crater', 'description' => 'Lanjut trekking 4 jam ke crater rim Sembalun (2.639 mdpl).'],
                        ['title' => 'Camp at Crater Rim', 'description' => 'Set up camp, dinner, dan briefing untuk summit attack besok. Tidur di tenda.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Summit Attack (02:00)', 'description' => 'Bangun tengah malam, trekking 3-4 jam ke puncak Rinjani (3.726 mdpl).'],
                        ['title' => 'Rinjani Summit Sunrise', 'description' => 'Saksikan sunrise spektakuler dari puncak dengan view 360° dan Gunung Agung Bali!'],
                        ['title' => 'Descent to Crater Rim', 'description' => 'Turun kembali ke camp crater rim untuk breakfast dan istirahat.'],
                        ['title' => 'Trek to Segara Anak Lake', 'description' => 'Turun ke Danau Segara Anak (2.000 mdpl), danau kawah yang indah.'],
                        ['title' => 'Hot Spring & Camp', 'description' => 'Berendam di hot spring alami, camp di tepi danau dengan view memukau.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Descent via Senaru', 'description' => 'Turun via jalur Senaru melewati hutan tropis dan air terjun kecil (6-7 jam).'],
                        ['title' => 'Senaru Village Arrival', 'description' => 'Tiba di Senaru village, makan siang dan serah terima sertifikat pendakian.'],
                        ['title' => 'Transfer Back', 'description' => 'Transfer kembali ke hotel di Senggigi atau Mataram.'],
                    ]],
                ],
                'inclusions' => [
                    'Experienced trekking guide',
                    'Porter untuk logistik',
                    'Tenda, sleeping bag, matras',
                    'Makan 3x sehari di gunung',
                    'Air mineral & snack',
                    'Peralatan camping & masak',
                    'Tiket masuk Rinjani National Park',
                    'Sertifikat pendakian',
                ],
                'exclusions' => [
                    'Hotel sebelum/sesudah trek',
                    'Carrier/porter pribadi (extra)',
                    'Sleeping bag quality upgrade',
                    'Tips guide & porter',
                    'Travel insurance',
                ],
            ],

            // LABUAN BAJO PACKAGES (2)
            [
                'name' => 'Labuan Bajo Komodo Explorer 4D3N',
                'slug' => 'labuan-bajo-komodo-explorer-4d3n',
                'category' => 'adventure',
                'description' => 'Jelajahi Taman Nasional Komodo dengan liveaboard. Bertemu komodo dragon, snorkeling dengan manta rays, Pink Beach, dan pulau-pulau eksotis lainnya.',
                'location' => 'Labuan Bajo - Komodo',
                'duration_days' => 4,
                'duration_nights' => 3,
                'max_participants' => 16,
                'currency' => 'USD',
                'price' => 650,
                'child_price' => 520,
                'featured_image' => 'packages/komodo-explorer.jpg',
                'status' => 'active',
                'keywords' => 'labuan bajo, komodo dragon, liveaboard, pink beach, diving, flores',
                'tag_slugs' => ['labuan-bajo', 'adventure', 'liveaboard', 'wildlife', 'snorkeling'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Arrival & Boarding', 'description' => 'Dijemput di airport/hotel dan boarding ke kapal liveaboard, briefing keselamatan.'],
                        ['title' => 'Kelor Island', 'description' => 'Snorkeling pertama di Pulau Kelor dengan terumbu karang yang masih pristine.'],
                        ['title' => 'Manjarite Beach', 'description' => 'Trekking ringan ke viewpoint untuk sunset dengan pemandangan teluk yang indah.'],
                        ['title' => 'Dinner on Board', 'description' => 'BBQ dinner di deck kapal sambil menikmati bintang-bintang. Overnight di kapal.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Padar Island Sunrise Trek', 'description' => 'Trekking pagi ke puncak Padar untuk sunrise dan view 4 teluk yang ikonik!'],
                        ['title' => 'Long Beach Snorkeling', 'description' => 'Snorkeling di Long Beach dengan visibility tinggi dan banyak marine life.'],
                        ['title' => 'Pink Beach', 'description' => 'Bersantai dan snorkeling di Pink Beach dengan pasir merah muda yang unik.'],
                        ['title' => 'Komodo Island Trek', 'description' => 'Trekking dengan ranger untuk bertemu komodo dragon di habitat aslinya!'],
                        ['title' => 'Manta Point', 'description' => 'Snorkeling dengan manta rays raksasa yang jinak, pengalaman unforgettable!'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Gili Lawa Sunrise', 'description' => 'Trekking sunrise di Gili Lawa dengan pemandangan 360° pulau-pulau sekitar.'],
                        ['title' => 'Gili Lawa Snorkeling', 'description' => 'Snorkeling di spot dengan current yang membawa banyak ikan besar.'],
                        ['title' => 'Siaba Island (Turtle City)', 'description' => 'Snorkeling dengan penyu hijau yang banyak dan jinak di Siaba Island.'],
                        ['title' => 'Taka Makassar', 'description' => 'Pulau pasir putih yang muncul saat surut, perfect untuk foto dan snorkeling.'],
                        ['title' => 'Kalong Island Sunset', 'description' => 'Saksikan ribuan kalong terbang keluar saat sunset, pemandangan magis!'],
                    ]],
                    ['day' => 4, 'items' => [
                        ['title' => 'Kanawa Island Snorkeling', 'description' => 'Snorkeling terakhir di Kanawa dengan coral garden yang colorful.'],
                        ['title' => 'Return to Labuan Bajo', 'description' => 'Berlayar kembali ke Labuan Bajo, sarapan di kapal.'],
                        ['title' => 'Disembark & Transfer', 'description' => 'Turun dari kapal dan transfer ke hotel atau airport untuk penerbangan pulang.'],
                    ]],
                ],
                'inclusions' => [
                    '3 nights on liveaboard boat',
                    'Full board meals (3x daily)',
                    'Snorkeling equipment & guide',
                    'Komodo National Park fees',
                    'Ranger fees',
                    'Mineral water & coffee/tea',
                    'Airport/hotel transfer',
                ],
                'exclusions' => [
                    'Flight tickets',
                    'Alcoholic beverages',
                    'Diving equipment (extra)',
                    'Tips for crew',
                    'Travel insurance',
                ],
            ],
            [
                'name' => 'Labuan Bajo Land Tour 3D2N',
                'slug' => 'labuan-bajo-land-tour-3d2n',
                'category' => 'culture',
                'description' => 'Eksplorasi Labuan Bajo dan sekitarnya via darat. Kunjungi desa tradisional, Wae Rebo, Spider Web Rice Fields, dan air terjun tersembunyi di Flores.',
                'location' => 'Labuan Bajo - Flores',
                'duration_days' => 3,
                'duration_nights' => 2,
                'max_participants' => 12,
                'currency' => 'USD',
                'price' => 275,
                'child_price' => 205,
                'featured_image' => 'packages/flores-land.jpg',
                'status' => 'active',
                'keywords' => 'labuan bajo, wae rebo, flores, culture, traditional village, spider web',
                'tag_slugs' => ['labuan-bajo', 'flores', 'culture', 'heritage', 'trekking'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Pickup & Journey Begin', 'description' => 'Dijemput pagi dan perjalanan via darat ke Wae Rebo (5-6 jam + trekking).'],
                        ['title' => 'Denge Village', 'description' => 'Tiba di Denge village, starting point untuk trekking 3-4 jam ke Wae Rebo.'],
                        ['title' => 'Trek to Wae Rebo', 'description' => 'Trekking menanjak melewati hutan dan sawah dengan pemandangan luar biasa.'],
                        ['title' => 'Wae Rebo Traditional Village', 'description' => 'Tiba di desa tradisional Wae Rebo (1.200 mdpl) dengan rumah Mbaru Niang khas cone-shaped.'],
                        ['title' => 'Welcome Ceremony', 'description' => 'Upacara penyambutan tradisional dari warga dengan tarian dan kopi Flores.'],
                        ['title' => 'Homestay Wae Rebo', 'description' => 'Menginap di rumah tradisional bersama keluarga lokal, pengalaman autentik!'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Sunrise at Wae Rebo', 'description' => 'Bangun pagi untuk melihat sunrise di atas awan, view desa yang magical!'],
                        ['title' => 'Village Tour', 'description' => 'Keliling desa, belajar tentang budaya Manggarai, tenun tradisional, dan daily life.'],
                        ['title' => 'Trek Down to Denge', 'description' => 'Trekking turun kembali ke Denge village dan perjalanan ke Ruteng.'],
                        ['title' => 'Spider Web Rice Fields', 'description' => 'Foto di Cancar spider web rice fields yang unik dengan pola seperti jaring laba-laba!'],
                        ['title' => 'Check-in Ruteng Hotel', 'description' => 'Check-in hotel di Ruteng, kota di dataran tinggi dengan udara sejuk.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Ranaka Lake', 'description' => 'Kunjungi danau Ranaka dengan pemandangan indah dan suasana tenang.'],
                        ['title' => 'Cunca Rami Waterfall', 'description' => 'Trekking ke air terjun Cunca Rami yang tersembunyi, berenang di kolam alami.'],
                        ['title' => 'Liang Bua Cave', 'description' => 'Gua tempat ditemukannya fosil Homo floresiensis (manusia hobbit).'],
                        ['title' => 'Return to Labuan Bajo', 'description' => 'Perjalanan kembali ke Labuan Bajo dan transfer ke hotel/airport.'],
                    ]],
                ],
                'inclusions' => [
                    'Transportasi 4WD + driver',
                    '1 night homestay Wae Rebo',
                    '1 night hotel Ruteng',
                    'All meals during trek',
                    'Local guide Wae Rebo',
                    'Village donation fee',
                    'Tiket masuk objek wisata',
                ],
                'exclusions' => [
                    'Hotel di Labuan Bajo',
                    'Meals (selain trek)',
                    'Porter pribadi',
                    'Tips guide & driver',
                    'Personal expenses',
                ],
            ],

            // LONG TRIP PACKAGES (3)
            [
                'name' => 'Java Bali Overland 7D6N',
                'slug' => 'java-bali-overland-7d6n',
                'category' => 'adventure',
                'description' => 'Petualangan epik melintasi Jawa dan Bali. Dari Yogyakarta, Bromo, Ijen, hingga Bali. Kombinasi budaya, gunung berapi, dan pantai-pantai eksotis.',
                'location' => 'Yogyakarta - Bromo - Ijen - Bali',
                'duration_days' => 7,
                'duration_nights' => 6,
                'max_participants' => 15,
                'currency' => 'USD',
                'price' => 440,
                'child_price' => 335,
                'featured_image' => 'packages/java-bali-overland.jpg',
                'status' => 'active',
                'keywords' => 'java bali, overland, bromo, ijen, yogyakarta, cultural, adventure',
                'tag_slugs' => ['java', 'bali', 'adventure', 'long-trip', 'overland'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Arrival Yogyakarta', 'description' => 'Dijemput di airport/stasiun dan check-in hotel.'],
                        ['title' => 'Borobudur Temple', 'description' => 'Kunjungi Borobudur, candi Buddha terbesar di dunia (UNESCO).'],
                        ['title' => 'Prambanan Temple', 'description' => 'Candi Hindu megah dengan relief Ramayana yang indah.'],
                        ['title' => 'Malioboro Night', 'description' => 'Jalan-jalan di Malioboro, belanja dan kuliner khas Jogja.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Keraton Yogyakarta', 'description' => 'Istana Sultan dengan museum dan pertunjukan gamelan.'],
                        ['title' => 'Taman Sari', 'description' => 'Bekas taman istana dengan kolam pemandian dan tunnel.'],
                        ['title' => 'Journey to Bromo', 'description' => 'Perjalanan panjang 9-10 jam ke Bromo area via tol Trans Jawa.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Bromo Sunrise (03:00)', 'description' => 'Jeep tour ke Penanjakan viewpoint untuk sunrise spektakuler.'],
                        ['title' => 'Bromo Crater Trek', 'description' => 'Jalan melintasi lautan pasir dan naik ke kawah Bromo.'],
                        ['title' => 'Savanna & Whispering Sand', 'description' => 'Explore savanna luas dan padang pasir berbisik.'],
                        ['title' => 'Journey to Banyuwangi', 'description' => 'Perjalanan 7-8 jam ke Banyuwangi untuk Ijen tour besok.'],
                    ]],
                    ['day' => 4, 'items' => [
                        ['title' => 'Ijen Blue Fire (00:00)', 'description' => 'Trekking malam untuk melihat blue fire phenomenon!'],
                        ['title' => 'Ijen Sunrise', 'description' => 'Sunrise di kawah dengan danau asam tosca yang cantik.'],
                        ['title' => 'Ferry to Bali', 'description' => 'Menyeberang ke Bali via Ketapang-Gilimanuk ferry (1 jam).'],
                        ['title' => 'West Bali Journey', 'description' => 'Perjalanan melintasi West Bali National Park ke Ubud/Sanur.'],
                    ]],
                    ['day' => 5, 'items' => [
                        ['title' => 'Tegallalang Rice Terrace', 'description' => 'Sawah bertingkat iconic dengan swing di atas jurang.'],
                        ['title' => 'Tirta Empul', 'description' => 'Holy spring temple untuk ritual purification.'],
                        ['title' => 'Ubud Monkey Forest', 'description' => 'Hutan suci dengan monkeys dan ancient temples.'],
                        ['title' => 'Ubud Traditional Dance', 'description' => 'Pertunjukan tari Legong atau Barong di Ubud Palace.'],
                    ]],
                    ['day' => 6, 'items' => [
                        ['title' => 'Uluwatu Temple', 'description' => 'Pura di tebing 70m dengan view samudra Hindia.'],
                        ['title' => 'Kecak Fire Dance', 'description' => 'Pertunjukan Kecak sunset di amphitheater Uluwatu.'],
                        ['title' => 'Jimbaran Seafood', 'description' => 'Dinner seafood di tepi pantai Jimbaran.'],
                        ['title' => 'Hotel Nusa Dua', 'description' => 'Check-in hotel di Nusa Dua beach area.'],
                    ]],
                    ['day' => 7, 'items' => [
                        ['title' => 'Beach Time Nusa Dua', 'description' => 'Free time untuk berenang dan bersantai di pantai hotel.'],
                        ['title' => 'Tanah Lot Sunset', 'description' => 'Kunjungi Tanah Lot untuk sunset farewell yang indah.'],
                        ['title' => 'Shopping & Transfer', 'description' => 'Last minute shopping dan transfer ke airport.'],
                    ]],
                ],
                'inclusions' => [
                    'Hotel 6 nights (all locations)',
                    'Daily breakfast',
                    'Transportasi overland',
                    'Bromo jeep 4WD',
                    'Ijen trekking guide',
                    'Ferry Bali',
                    'Tiket semua objek wisata',
                    '2x cultural performance',
                    '1x seafood dinner',
                ],
                'exclusions' => [
                    'Flight tickets',
                    'Lunch & dinner (kecuali mentioned)',
                    'Tips guide & driver',
                    'Personal expenses',
                    'Travel insurance',
                ],
            ],
            [
                'name' => 'Bali Lombok Gili Grand Tour 8D7N',
                'slug' => 'bali-lombok-gili-grand-tour-8d7n',
                'category' => 'beach',
                'description' => 'Tour lengkap Bali, Lombok, dan Gili Islands. Kombinasi budaya Bali, pantai-pantai eksotis, snorkeling dengan penyu, dan petualangan air terjun Lombok.',
                'location' => 'Bali - Lombok - Gili Islands',
                'duration_days' => 8,
                'duration_nights' => 7,
                'max_participants' => 18,
                'currency' => 'USD',
                'price' => 485,
                'child_price' => 375,
                'featured_image' => 'packages/bali-lombok-gili.jpg',
                'status' => 'active',
                'keywords' => 'bali lombok gili, grand tour, beach, culture, snorkeling, waterfall',
                'tag_slugs' => ['bali', 'lombok', 'long-trip', 'beach', 'island-hopping'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Arrival Bali', 'description' => 'Dijemput di airport dan check-in hotel Kuta/Seminyak.'],
                        ['title' => 'Kuta Beach Sunset', 'description' => 'Bersantai di Pantai Kuta dan nikmati sunset pertama.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'GWK Cultural Park', 'description' => 'Patung Garuda Wisnu Kencana raksasa 121 meter.'],
                        ['title' => 'Uluwatu Temple', 'description' => 'Pura di tebing dengan pemandangan dramatis.'],
                        ['title' => 'Kecak Dance', 'description' => 'Pertunjukan tari Kecak sunset yang menakjubkan.'],
                        ['title' => 'Jimbaran Dinner', 'description' => 'Seafood BBQ dinner di tepi pantai.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Tegallalang Rice Terrace', 'description' => 'Sawah bertingkat dengan swing Instagram-able.'],
                        ['title' => 'Tirta Empul', 'description' => 'Holy spring temple dengan ritual purification.'],
                        ['title' => 'Coffee Plantation', 'description' => 'Cicipi kopi luwak dan berbagai teh Bali.'],
                        ['title' => 'Ubud Monkey Forest', 'description' => 'Hutan suci dengan ratusan monkeys jinak.'],
                    ]],
                    ['day' => 4, 'items' => [
                        ['title' => 'Fast Boat to Lombok', 'description' => 'Perjalanan 2-3 jam dengan fast boat ke Lombok.'],
                        ['title' => 'Check-in Senggigi', 'description' => 'Check-in hotel di Senggigi beach dan free time.'],
                        ['title' => 'Senggigi Sunset', 'description' => 'Menikmati sunset di Pantai Senggigi.'],
                    ]],
                    ['day' => 5, 'items' => [
                        ['title' => 'Sendang Gile Waterfall', 'description' => 'Air terjun megah dengan trekking ringan.'],
                        ['title' => 'Traditional Sasak Village', 'description' => 'Desa tradisional dengan rumah bambu unik.'],
                        ['title' => 'Boat to Gili Trawangan', 'description' => 'Naik boat ke Gili T, pulau paradise tanpa motor!'],
                    ]],
                    ['day' => 6, 'items' => [
                        ['title' => 'Gili 3 Islands Hopping', 'description' => 'Tour ke Gili Meno dan Gili Air dengan snorkeling.'],
                        ['title' => 'Turtle Snorkeling', 'description' => 'Berenang dengan penyu hijau di Turtle Point!'],
                        ['title' => 'Underwater Statue', 'description' => 'Snorkeling ke sculpture garden bawah laut.'],
                        ['title' => 'Gili T Sunset Swing', 'description' => 'Foto di swing sunset yang iconic.'],
                    ]],
                    ['day' => 7, 'items' => [
                        ['title' => 'Free Morning Gili T', 'description' => 'Bebas untuk snorkeling, dive, atau bersepeda keliling pulau.'],
                        ['title' => 'Boat to Lombok', 'description' => 'Kembali ke Lombok siang hari.'],
                        ['title' => 'Pink Beach Lombok', 'description' => 'Kunjungi Pantai Tangsi dengan pasir pink yang langka.'],
                        ['title' => 'Hotel Senggigi', 'description' => 'Kembali ke hotel Senggigi untuk malam terakhir.'],
                    ]],
                    ['day' => 8, 'items' => [
                        ['title' => 'Shopping Lombok', 'description' => 'Belanja kerajinan mutiara, tenun, dan pottery.'],
                        ['title' => 'Transfer Airport', 'description' => 'Antar ke Lombok airport untuk penerbangan pulang.'],
                    ]],
                ],
                'inclusions' => [
                    'Hotel 7 nights (Bali 3, Senggigi 2, Gili T 2)',
                    'Daily breakfast',
                    'Fast boat Bali-Lombok',
                    'Boat Lombok-Gili-Lombok',
                    'Gili 3 islands snorkeling tour',
                    'Snorkeling equipment',
                    'All entrance tickets',
                    'Transportation',
                    '1x seafood dinner',
                ],
                'exclusions' => [
                    'Flight tickets',
                    'Meals (selain breakfast & 1 dinner)',
                    'Water sports activities',
                    'Bicycle rental Gili',
                    'Tips guide',
                ],
            ],
            [
                'name' => 'Ultimate Indonesia Explorer 14D13N',
                'slug' => 'ultimate-indonesia-explorer-14d13n',
                'category' => 'adventure',
                'description' => 'Paket wisata ultimate melintasi Jawa, Bali, Lombok, dan Komodo. Pengalaman lengkap kultur, gunung berapi, pantai, dan wildlife. Best of Indonesia in one trip!',
                'location' => 'Jakarta - Yogya - Bromo - Bali - Lombok - Komodo',
                'duration_days' => 14,
                'duration_nights' => 13,
                'max_participants' => 12,
                'currency' => 'USD',
                'price' => 2800,
                'child_price' => 2200,
                'featured_image' => 'packages/ultimate-indonesia.jpg',
                'status' => 'active',
                'keywords' => 'indonesia tour, java bali lombok komodo, ultimate trip, grand tour, adventure',
                'tag_slugs' => ['java', 'bali', 'lombok', 'labuan-bajo', 'long-trip', 'premium', 'adventure'],
                'itineraries' => [
                    ['day' => 1, 'items' => [
                        ['title' => 'Arrival Jakarta', 'description' => 'Dijemput di Soekarno-Hatta Airport dan check-in hotel.'],
                        ['title' => 'Jakarta City Tour', 'description' => 'National Monument, Old Town Batavia, and Ancol Beach.'],
                    ]],
                    ['day' => 2, 'items' => [
                        ['title' => 'Flight to Yogyakarta', 'description' => 'Domestic flight dari Jakarta ke Yogyakarta (1 jam).'],
                        ['title' => 'Borobudur & Prambanan', 'description' => 'Dua UNESCO World Heritage temples dalam satu hari.'],
                        ['title' => 'Malioboro Night', 'description' => 'Jalan-jalan di Malioboro, shopping dan street food.'],
                    ]],
                    ['day' => 3, 'items' => [
                        ['title' => 'Keraton & Taman Sari', 'description' => 'Sultan Palace dan Water Castle.'],
                        ['title' => 'Journey to Bromo', 'description' => 'Perjalanan overland 10 jam ke Bromo area.'],
                    ]],
                    ['day' => 4, 'items' => [
                        ['title' => 'Bromo Sunrise Tour', 'description' => 'Jeep 4WD ke Penanjakan dan crater exploration.'],
                        ['title' => 'Journey to Banyuwangi', 'description' => 'Perjalanan ke Banyuwangi for Ijen prep.'],
                    ]],
                    ['day' => 5, 'items' => [
                        ['title' => 'Ijen Blue Fire Trek', 'description' => 'Midnight trekking untuk blue fire phenomenon.'],
                        ['title' => 'Ferry & Drive to Bali', 'description' => 'Ferry crossing dan drive ke Ubud, Bali.'],
                    ]],
                    ['day' => 6, 'items' => [
                        ['title' => 'Ubud Culture Day', 'description' => 'Rice terraces, monkey forest, temples, art market.'],
                        ['title' => 'Traditional Dance Show', 'description' => 'Barong or Legong dance performance.'],
                    ]],
                    ['day' => 7, 'items' => [
                        ['title' => 'Nusa Penida Day Trip', 'description' => 'Kelingking Beach, Angel Billabong, Broken Beach.'],
                        ['title' => 'Crystal Bay Snorkeling', 'description' => 'Snorkeling dengan manta rays (seasonal).'],
                    ]],
                    ['day' => 8, 'items' => [
                        ['title' => 'South Bali Tour', 'description' => 'GWK, Uluwatu Temple, Kecak Dance, Jimbaran Seafood.'],
                    ]],
                    ['day' => 9, 'items' => [
                        ['title' => 'Fast Boat to Lombok', 'description' => '3-hour speedboat ke Lombok island.'],
                        ['title' => 'Senggigi & Sunset', 'description' => 'Check-in dan enjoy Senggigi beach.'],
                    ]],
                    ['day' => 10, 'items' => [
                        ['title' => 'Lombok Waterfalls', 'description' => 'Sendang Gile and Tiu Kelep waterfalls trekking.'],
                        ['title' => 'To Gili Trawangan', 'description' => 'Boat ke paradise island Gili T.'],
                    ]],
                    ['day' => 11, 'items' => [
                        ['title' => 'Gili 3 Islands Tour', 'description' => 'Island hopping with turtle snorkeling and diving spots.'],
                    ]],
                    ['day' => 12, 'items' => [
                        ['title' => 'Flight to Labuan Bajo', 'description' => 'Domestic flight ke Labuan Bajo, gateway to Komodo.'],
                        ['title' => 'Liveaboard Boarding', 'description' => 'Board kapal liveaboard untuk 2D1N Komodo trip.'],
                        ['title' => 'First Snorkeling Stop', 'description' => 'Kelor or Bidadari island snorkeling.'],
                    ]],
                    ['day' => 13, 'items' => [
                        ['title' => 'Padar Island Sunrise', 'description' => 'Iconic Padar viewpoint trekking.'],
                        ['title' => 'Pink Beach', 'description' => 'Unique pink sand beach exploration.'],
                        ['title' => 'Komodo Island', 'description' => 'Meet Komodo dragons with ranger guide.'],
                        ['title' => 'Manta Point', 'description' => 'Swim with giant manta rays!'],
                        ['title' => 'Kalong Sunset', 'description' => 'Thousands of flying foxes at sunset.'],
                    ]],
                    ['day' => 14, 'items' => [
                        ['title' => 'Last Snorkeling', 'description' => 'Taka Makassar or Kanawa island.'],
                        ['title' => 'Return & Disembark', 'description' => 'Back to Labuan Bajo harbor.'],
                        ['title' => 'Transfer Airport', 'description' => 'Flight pulang atau lanjut destinasi next.'],
                    ]],
                ],
                'inclusions' => [
                    'Hotel 11 nights + liveaboard 2 nights',
                    'Daily breakfast',
                    '2 domestic flights',
                    'Ferry Bali crossing',
                    'Fast boat Bali-Lombok',
                    'All transportation & transfers',
                    'Bromo jeep 4WD',
                    'Komodo liveaboard full board',
                    'All entrance tickets',
                    'Snorkeling equipment',
                    'Local guides all destinations',
                    '3x special dinners',
                ],
                'exclusions' => [
                    'International flights',
                    'Visa fees',
                    'Lunch & dinner (kecuali mentioned)',
                    'Tips for guides & drivers',
                    'Travel insurance',
                    'Personal expenses',
                    'Optional activities',
                ],
            ],
        ];

        foreach ($packages as $packageData) {
            $itineraries = $packageData['itineraries'];
            $inclusions = $packageData['inclusions'];
            $exclusions = $packageData['exclusions'];
            $tagSlugs = $packageData['tag_slugs'];

            unset($packageData['itineraries'], $packageData['inclusions'], $packageData['exclusions'], $packageData['tag_slugs']);

            // Upsert package
            $package = TravelPackage::updateOrCreate(
                ['slug' => $packageData['slug']],
                $packageData
            );

            // Reset relations to avoid duplicates on re-seed
            $package->itineraries()->delete();
            $package->inclusions()->delete();
            $package->exclusions()->delete();
            $package->galleries()->delete();

            // Create itineraries
            foreach ($itineraries as $dayData) {
                $dayNumber = $dayData['day'];
                $order = 1;
                foreach ($dayData['items'] as $item) {
                    PackageItinerary::create([
                        'travel_package_id' => $package->id,
                        'day_number' => $dayNumber,
                        'title' => $item['title'],
                        'description' => $item['description'],
                        'order' => $order++,
                    ]);
                }
            }

            // Create inclusions
            $order = 1;
            foreach ($inclusions as $inclusion) {
                PackageInclusion::create([
                    'travel_package_id' => $package->id,
                    'description' => $inclusion,
                    'order' => $order++,
                ]);
            }

            // Create exclusions
            $order = 1;
            foreach ($exclusions as $exclusion) {
                PackageExclusion::create([
                    'travel_package_id' => $package->id,
                    'description' => $exclusion,
                    'order' => $order++,
                ]);
            }

            // Create galleries (4 images per package)
            for ($i = 1; $i <= 4; $i++) {
                PackageGallery::create([
                    'travel_package_id' => $package->id,
                    'image_path' => "packages/{$package->slug}-{$i}.jpg",
                    'order' => $i,
                ]);
            }

            // Attach tags
            $tagIds = [];
            foreach ($tagSlugs as $slug) {
                if (isset($tagMap[$slug])) {
                    $tagIds[] = $tagMap[$slug];
                }
            }
            $package->tags()->sync($tagIds);
        }

        $this->command->info('11 travel packages seeded with USD pricing and tag assignments.');
    }
}
