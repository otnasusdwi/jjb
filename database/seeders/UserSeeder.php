<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@jjbtravelbali.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Admin
        User::create([
            'name' => 'Admin JJB Travel',
            'email' => 'admin@jjbtravelbali.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Sample Affiliate
        User::create([
            'name' => 'Affiliate Demo',
            'email' => 'affiliate@example.com',
            'password' => Hash::make('password'),
            'role' => 'affiliate',
            'status' => 'active',
            'affiliate_code' => 'JJB001',
            'email_verified_at' => now(),
        ]);
    }
}
