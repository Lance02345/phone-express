<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class PixelSeeder extends Seeder
{
    public function run(): void
    {
        $pixels = [
            ["name" => "Google Pixel 7 Pro 5G 256GB", "price" => 38000, "image_path" => "Images/google/pixel7pro.jpg"],
            ["name" => "Google Pixel 8A 5G 128GB", "price" => 34000, "image_path" => "Images/google/pixel8a.jpg"],
            ["name" => "Google Pixel 8 Pro 5G 256GB", "price" => 55000, "image_path" => "Images/google/pixel8pro.jpg"],
            ["name" => "Google Pixel 9A 5G 128GB", "price" => 49000, "image_path" => "Images/google/pixel9a.png"],
            ["name" => "Google Pixel 9 Pro 5G 128GB", "price" => 64000, "image_path" => "Images/google/pixel9pro.png"],
            ["name" => "Google Pixel 9 Pro 5G 256GB", "price" => 68000, "image_path" => "Images/google/pixel9pro.png"],
        ];

        foreach ($pixels as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
