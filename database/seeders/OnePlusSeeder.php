<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class OnePlusSeeder extends Seeder
{
    public function run(): void
    {
        $oneplus = [
            ["name" => "OnePlus N6 128GB + 6GB RAM", "price" => 29500, "image_path" => "Images/oneplus/oneplusn6.jpg"],
            ["name" => "OnePlus Nord CE5 256GB + 8GB RAM", "price" => 41000, "image_path" => "Images/oneplus/oneplusnordce5.jpg"],
            ["name" => "OnePlus Nord CE6 256GB + 8GB RAM", "price" => 51000, "image_path" => "Images/oneplus/oneplusnordce6.jpg"],
            ["name" => "OnePlus 13 256GB + 12GB RAM", "price" => 85000, "image_path" => "Images/oneplus/oneplus13.jpg"],
            ["name" => "OnePlus 15R 256GB + 12GB RAM", "price" => 75000, "image_path" => "Images/oneplus/oneplus15r.jpg"],
            ["name" => "OnePlus 15 256GB + 12GB RAM", "price" => 107000, "image_path" => "Images/oneplus/oneplus15.jpg"],
            ["name" => "OnePlus 15 512GB + 16GB RAM", "price" => 125000, "image_path" => "Images/oneplus/oneplus15.jpg"],
        ];

        foreach ($oneplus as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
