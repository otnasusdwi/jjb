<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'JJB Travel Bali',
                'type' => 'string',
                'description' => 'Company name displayed throughout the system',
            ],
            [
                'key' => 'company_email',
                'value' => 'info@jjbtravelbali.com',
                'type' => 'string',
                'description' => 'Company contact email',
            ],
            [
                'key' => 'company_phone',
                'value' => '+62 361 123456',
                'type' => 'string',
                'description' => 'Company contact phone number',
            ],
            [
                'key' => 'company_whatsapp',
                'value' => '+62 812 3456 7890',
                'type' => 'string',
                'description' => 'Company WhatsApp number',
            ],
            [
                'key' => 'company_address',
                'value' => 'Jl. Raya Ubud No. 123, Ubud, Gianyar, Bali 80571',
                'type' => 'text',
                'description' => 'Company address',
            ],
            [
                'key' => 'company_logo',
                'value' => 'jjb.png',
                'type' => 'string',
                'description' => 'Company logo path (located in public folder)',
            ],
            [
                'key' => 'default_commission_rate',
                'value' => '10.00',
                'type' => 'string',
                'description' => 'Default commission rate for new affiliates (%)',
            ],
            [
                'key' => 'auto_approve_affiliates',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'Auto approve new affiliate registrations',
            ],
            [
                'key' => 'max_upload_size',
                'value' => '5120',
                'type' => 'integer',
                'description' => 'Maximum file upload size in KB',
            ],
            [
                'key' => 'allowed_file_types',
                'value' => '["jpg", "jpeg", "png", "pdf", "doc", "docx"]',
                'type' => 'json',
                'description' => 'Allowed file types for uploads',
            ],
            [
                'key' => 'site_meta_title',
                'value' => 'JJB Travel Bali - Your Gateway to Amazing Bali Adventures',
                'type' => 'string',
                'description' => 'Default meta title for SEO',
            ],
            [
                'key' => 'site_meta_description',
                'value' => 'Discover Bali with JJB Travel Bali. Authentic tours, cultural experiences, and adventure packages with trusted local guides.',
                'type' => 'text',
                'description' => 'Default meta description for SEO',
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/jjbtravelbali',
                'type' => 'string',
                'description' => 'Facebook page URL',
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/jjbtravelbali',
                'type' => 'string',
                'description' => 'Instagram page URL',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/jjbtravelbali',
                'type' => 'string',
                'description' => 'YouTube channel URL',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('system_settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => $setting['type'],
                'description' => $setting['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
