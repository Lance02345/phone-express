<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class AppleAccessorySeeder extends Seeder
{
    public function run(): void
    {
        $accessories = [
            // APPLE WATCH - BRAND NEW
            ["name" => "Apple Watch SE 3 40mm", "price" => 35000, "image_path" => "Images/apple/watchse3.jpg"],
            ["name" => "Apple Watch SE 3 44mm", "price" => 39000, "image_path" => "Images/apple/watchse3.jpg"],
            ["name" => "Apple Watch Series 11 42mm", "price" => 48000, "image_path" => "Images/apple/watchseries11.jpg"],
            ["name" => "Apple Watch Series 11 46mm", "price" => 53000, "image_path" => "Images/apple/watchseries11.jpg"],
            ["name" => "Apple Watch Series 12 42mm", "price" => 58500, "image_path" => "Images/apple/watchseries12.jpg"],
            ["name" => "Apple Watch Series 12 46mm", "price" => 63000, "image_path" => "Images/apple/watchseries12.jpg"],
            ["name" => "Apple Watch Ultra 3 49mm", "price" => 100000, "image_path" => "Images/apple/watchultra3.jpg"],
            ["name" => "Apple Watch Ultra 3 49mm (Stainless)", "price" => 108000, "image_path" => "Images/apple/watchultra3.jpg"],

            // AIRPODS
            ["name" => "AirPods 4", "price" => 18000, "image_path" => "Images/apple/airpods4.jpg"],
            ["name" => "AirPods 4 ANC", "price" => 22500, "image_path" => "Images/apple/airpods4anc.jpg"],
            ["name" => "AirPods 5", "price" => 23500, "image_path" => "Images/apple/airpods5.jpg"],
            ["name" => "AirPods Pro 2", "price" => 29000, "image_path" => "Images/apple/airpodspro2.jpg"],
            ["name" => "AirPods Pro 3 (2 Years Warranty)", "price" => 32000, "image_path" => "Images/apple/airpodspro3.jpg"],
            ["name" => "AirPods Max 2", "price" => 68000, "image_path" => "Images/apple/airpodsmax2.jpg"],
            ["name" => "AirPods Max USB-C (Active Warranty)", "price" => 46000, "image_path" => "Images/apple/airpodsmaxusbc.jpg"],

            // ACCESSORIES
            ["name" => "Apple Power Adapter 3-Pin", "price" => 3500, "image_path" => "Images/apple/poweradapter3pin.jpg"],
            ["name" => "Magic Mouse (Black)", "price" => 15000, "image_path" => "Images/apple/magicmouse-black.jpg"],
            ["name" => "Magic Mouse (White)", "price" => 17000, "image_path" => "Images/apple/magicmouse-white.jpg"],
            ["name" => "Apple Pencil 2nd Gen", "price" => 13000, "image_path" => "Images/apple/pencil2.jpg"],
            ["name" => "Apple Pencil USB-C", "price" => 15000, "image_path" => "Images/apple/pencilusbc.jpg"],
            ["name" => "Apple Pencil Pro", "price" => 18500, "image_path" => "Images/apple/pencilpro.jpg"],
            ["name" => "Magic Keyboard for iPad Pro M4/M5 11-inch", "price" => 46000, "image_path" => "Images/apple/magickeyboard.jpg"],
            ["name" => "Magic Keyboard for iPad Pro M4/M5 13-inch", "price" => 50000, "image_path" => "Images/apple/magickeyboard.jpg"],
        ];

        foreach ($accessories as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
