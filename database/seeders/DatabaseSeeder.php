<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (! config('supabase.auth_enabled')) {
            $this->call(AdminSeeder::class);
        }

        $this->call([
            NineAssociatesSeeder::class,
            ItServicesPortfolioSeeder::class,
            PagesSeeder::class,
        ]);
    }
}
