<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class PixelSeeder extends Seeder
{
    public function run(): void
    {
        $pixels = [
            // BRAND NEW
            ["name" => "Google Pixel 9A 5G 256GB + 8GB RAM", "price" => 65500, "image_path" => "Images/google/pixel9a.png"],
            ["name" => "Google Pixel 10A 5G 256GB + 8GB RAM", "price" => 73000, "image_path" => "Images/google/pixel10a.jpg"],
            ["name" => "Google Pixel 10 5G 128GB + 12GB RAM", "price" => 81000, "image_path" => "Images/google/pixel10.jpg"],
            ["name" => "Google Pixel 11 5G 256GB + 12GB RAM", "price" => 104000, "image_path" => "Images/google/pixel11.jpg"],
            ["name" => "Google Pixel 11 Pro 5G 256GB + 12GB RAM", "price" => 134000, "image_path" => "Images/google/pixel11pro.jpg"],
            ["name" => "Google Pixel 11 Pro XL 5G 256GB + 12GB RAM (Olive/Obsidian)", "price" => 136000, "image_path" => "Images/google/pixel11proxl.jpg"],
            ["name" => "Google Pixel 11 Pro XL 5G 256GB + 12GB RAM (Canyon/Fog)", "price" => 150000, "image_path" => "Images/google/pixel11proxl.jpg"],
            ["name" => "Google Pixel 11 Pro XL 5G 512GB + 12GB RAM", "price" => 169000, "image_path" => "Images/google/pixel11proxl.jpg"],

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
