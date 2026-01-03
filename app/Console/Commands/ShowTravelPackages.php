<?php

namespace App\Console\Commands;

use App\Models\TravelPackage;
use Illuminate\Console\Command;

class ShowTravelPackages extends Command
{
    protected $signature = 'packages:show';
    protected $description = 'Show all travel packages';

    public function handle()
    {
        $packages = TravelPackage::with('category')->get();

        $this->info('Travel Packages:');
        $this->line('');

        foreach ($packages as $package) {
            $this->line("📍 {$package->name}");
            $this->line("   💰 Adult Price: Rp " . number_format($package->price_adult));
            if ($package->price_child > 0) {
                $this->line("   👶 Child Price: Rp " . number_format($package->price_child));
            }
            $this->line("   📊 Difficulty: {$package->difficulty_level}");
            $this->line("   📂 Category: " . ($package->category ? $package->category->name : 'N/A'));
            $this->line("   🕒 Duration: {$package->duration_days} days" . ($package->duration_nights > 0 ? ", {$package->duration_nights} nights" : ""));
            $this->line("   👥 Max participants: {$package->max_participants}");
            $this->line('');
        }

        $this->info("Total packages: " . $packages->count());
    }
}
