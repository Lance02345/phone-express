<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class InfinixSeeder extends Seeder
{
    public function run(): void
    {
        $infinix = [
            // ZERO SERIES
            ["name" => "Infinix ZERO Flip 512GB + 8GB RAM (X6962)", "price" => 80000, "image_path" => "Images/infinix/zeroflip.jpg"],

            // NOTE SERIES
            ["name" => "Infinix Note 60 Pro 256GB + 8GB RAM (X6878)", "price" => 40800, "image_path" => "Images/infinix/note60pro.jpg"],
            ["name" => "Infinix Note EDGE 256GB + 8GB RAM (X6887)", "price" => 32400, "image_path" => "Images/infinix/noteedge.jpg"],
            ["name" => "Infinix Note 50 Pro 256GB + 8GB RAM (X6855)", "price" => 30900, "image_path" => "Images/infinix/note50pro.jpg"],

            // HOT 60 SERIES
            ["name" => "Infinix Hot 60 Pro+ 256GB + 8GB RAM (X6886)", "price" => 26700, "image_path" => "Images/infinix/hot60proplus.jpg"],
            ["name" => "Infinix Hot 60 Pro 128GB + 8GB RAM (X6885)", "price" => 19300, "image_path" => "Images/infinix/hot60proplus.jpg"],

            // HOT 60i SERIES
            ["name" => "Infinix Hot 60i 256GB + 8GB RAM (X6728)", "price" => 18500, "image_path" => "Images/infinix/hot60i.jpg"],
            ["name" => "Infinix Hot 60i 128GB + 6GB RAM (X6728B)", "price" => 15900, "image_path" => "Images/infinix/hot60i.jpg"],
            ["name" => "Infinix Hot 60i 128GB + 4GB RAM (X6728B)", "price" => 15000, "image_path" => "Images/infinix/hot60i.jpg"],

            // SMART SERIES
            ["name" => "Infinix Smart 20 128GB + 4GB RAM (X6840)", "price" => 14900, "image_path" => "Images/infinix/smart20.jpg"],
            ["name" => "Infinix Smart 10 64GB + 4GB RAM (X6725)", "price" => 12100, "image_path" => "Images/infinix/smart10.jpg"],

            // XPAD
            ["name" => "Infinix XPAD X1101 256GB + 4GB RAM", "price" => 18100, "image_path" => "Images/infinix/xpad.jpg"],
            ["name" => "Infinix XPAD X1101B 256GB + 4GB RAM (SIM Card)", "price" => 19500, "image_path" => "Images/infinix/xpad.jpg"],
        ];

        foreach ($infinix as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
