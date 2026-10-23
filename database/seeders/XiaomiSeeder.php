<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class XiaomiSeeder extends Seeder
{
    public function run(): void
    {
        $xiaomis = [
            ["name" => "Xiaomi 15T 512GB + 12GB RAM", "price" => 72000, "image_path" => "Images/xiaomi/xiaomi15t.jpg"],
            ["name" => "Poco M8 256GB + 8GB RAM", "price" => 35000, "image_path" => "Images/xiaomi/pocom8.jpg"],
            ["name" => "Poco X8 Pro 512GB + 12GB RAM", "price" => 63000, "image_path" => "Images/xiaomi/pocox8pro.jpg"],
        ];

        foreach ($xiaomis as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
