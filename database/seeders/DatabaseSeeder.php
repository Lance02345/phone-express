<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PhoneSeeder::class,
            SamsungSeeder::class,
            PixelSeeder::class,
            RedmiSeeder::class,
            OppoSeeder::class,
            VivoSeeder::class,
            TecnoSeeder::class,
            InfinixSeeder::class,
            HonorSeeder::class,
            ItelSeeder::class,
            OnePlusSeeder::class,
            NothingSeeder::class,
            XiaomiSeeder::class,
            AppleAccessorySeeder::class,
            CatalogueSeeder::class,
            PolicyArticleSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
