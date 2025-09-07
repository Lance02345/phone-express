<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class PhoneSeeder extends Seeder
{
    public function run(): void
    {
        $phones = [
            ["name" => "iPhone X 256GB", "price" => 25000, "image_path" => "Images/iphone x.jpg"],
            ["name" => "iPhone XR 128GB", "price" => 28000, "image_path" => "Images/iphone xr.jpg"],
            ["name" => "iPhone 11 64GB", "price" => 29500, "image_path" => "Images/iphone 11.jpg"],
            ["name" => "iPhone 11 128GB", "price" => 33500, "image_path" => "Images/iphone 11.jpg"],
            ["name" => "iPhone 11 Pro 256GB", "price" => 41000, "image_path" => "Images/iphone11pro.jpg"],
            ["name" => "iPhone 11 Pro 512GB", "price" => 43000, "image_path" => "Images/iphone11pro.jpg"],
            ["name" => "iPhone 11 Pro Max 256GB", "price" => 48500, "image_path" => "Images/iphone11promax.jpg"],
            ["name" => "iPhone 11 Pro Max 512GB", "price" => 57000, "image_path" => "Images/iphone11promax.jpg"],
            ["name" => "iPhone 12 128GB", "price" => 43000, "image_path" => "Images/iphone12.jpg"],
            ["name" => "iPhone 12 256GB", "price" => 45000, "image_path" => "Images/iphone12.jpg"],
            ["name" => "iPhone 12 Pro 128GB", "price" => 49000, "image_path" => "Images/12pro.jpg"],
            ["name" => "iPhone 12 Pro 256GB", "price" => 50000, "image_path" => "Images/12pro.jpg"],
            ["name" => "iPhone 12 Pro 512GB", "price" => 54000, "image_path" => "Images/12pro.jpg"],
            ["name" => "iPhone 12 Pro Max 128GB", "price" => 57500, "image_path" => "Images/iphone12promax.jpg"],
            ["name" => "iPhone 12 Pro Max 256GB", "price" => 64000, "image_path" => "Images/iphone12promax.jpg"],
            ["name" => "iPhone 13 128GB", "price" => 48500, "image_path" => "Images/iphone13.jpg"],
            ["name" => "iPhone 13 256GB", "price" => 54000, "image_path" => "Images/iphone13.jpg"],
            ["name" => "iPhone 13 512GB", "price" => 59000, "image_path" => "Images/iphone13.jpg"],
            ["name" => "iPhone 13 mini 128GB", "price" => 43000, "image_path" => "Images/iphone13mini.jpg"],
            ["name" => "iPhone 13 Pro 128GB", "price" => 60000, "image_path" => "Images/ihone13pro.jpg"],
            ["name" => "iPhone 13 Pro 256GB", "price" => 67000, "image_path" => "Images/ihone13pro.jpg"],
            ["name" => "iPhone 13 Pro Max 128GB", "price" => 67000, "image_path" => "Images/iphone13promax.jpg"],
            ["name" => "iPhone 13 Pro Max 256GB", "price" => 70000, "image_path" => "Images/iphone13promax.jpg"],
            ["name" => "iPhone 13 Pro Max 512GB", "price" => 76500, "image_path" => "Images/iphone13promax.jpg"],
            ["name" => "iPhone 14 128GB", "price" => 58000, "image_path" => "Images/iphone14.jpg"],
            ["name" => "iPhone 14 256GB", "price" => 63000, "image_path" => "Images/iphone14.jpg"],
            ["name" => "iPhone 14 Pro 128GB", "price" => 79000, "image_path" => "Images/iphone14pro.jpg"],
            ["name" => "iPhone 14 Pro 256GB", "price" => 83000, "image_path" => "Images/iphone14pro.jpg"],
            ["name" => "iPhone 14 Pro 512GB", "price" => 87500, "image_path" => "Images/iphone14pro.jpg"],
            ["name" => "iPhone 14 Plus 256GB", "price" => 71000, "image_path" => "Images/iphone14plus.jpg"],
            ["name" => "iPhone 14 Pro Max 128GB", "price" => 86000, "image_path" => "Images/iphone14promax.jpg"],
            ["name" => "iPhone 14 Pro Max 256GB", "price" => 93000, "image_path" => "Images/iphone14promax.jpg"],
            ["name" => "iPhone 15 128GB", "price" => 75000, "image_path" => "Images/iphone15.jpg"],
            ["name" => "iPhone 15 Plus 128GB", "price" => 82000, "image_path" => "Images/iphone15plus.jpg"],
            ["name" => "iPhone 15 Pro 256GB", "price" => 103000, "image_path" => "Images/iphone15pro.jpg"],
            ["name" => "iPhone 16", "price" => 0, "image_path" => "Images/iphone16.jpg"],
            ["name" => "iPhone 16 Plus", "price" => 0, "image_path" => "Images/iphone16plus.jpg"],
            ["name" => "iPhone 16 Pro", "price" => 0, "image_path" => "Images/iphone16pro.jpg"],
            ["name" => "iPhone 16 Pro Max", "price" => 0, "image_path" => "Images/iphone16promax.jpg"],
        ];

        foreach ($phones as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
