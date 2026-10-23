<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class NothingSeeder extends Seeder
{
    public function run(): void
    {
        $nothings = [
            ["name" => "Nothing Phone 3a Lite 128GB + 8GB RAM", "price" => 37000, "image_path" => "Images/nothing/phone3alite.jpg"],
            ["name" => "Nothing Phone 3a Lite 256GB + 8GB RAM", "price" => 41000, "image_path" => "Images/nothing/phone3alite.jpg"],
            ["name" => "Nothing Phone 3 256GB + 12GB RAM", "price" => 79500, "image_path" => "Images/nothing/phone3.jpg"],
            ["name" => "Nothing Phone 4a 256GB + 8GB RAM", "price" => 67500, "image_path" => "Images/nothing/phone4a.jpg"],
            ["name" => "Nothing Phone 4b 128GB + 8GB RAM", "price" => 58000, "image_path" => "Images/nothing/phone4b.jpg"],
        ];

        foreach ($nothings as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
