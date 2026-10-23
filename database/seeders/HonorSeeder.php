<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class HonorSeeder extends Seeder
{
    public function run(): void
    {
        $honors = [
            ["name" => "Honor Play 10 64GB + 4GB RAM", "price" => 14500, "image_path" => "Images/honor/honorplay10.png"],
            ["name" => "Honor X5c 64GB + 4GB RAM", "price" => 14400, "image_path" => "Images/honor/honorx5c.png"],
            ["name" => "Honor X5c Plus 128GB + 4GB RAM", "price" => 15700, "image_path" => "Images/honor/honorx5cplus.png"],
            ["name" => "Honor X6c 128GB + 6GB RAM", "price" => 19800, "image_path" => "Images/honor/honorx6c.png"],
            ["name" => "Honor X6c 256GB + 6GB RAM", "price" => 22100, "image_path" => "Images/honor/honorx6c.png"],
            ["name" => "Honor X7d 256GB + 8GB RAM", "price" => 29000, "image_path" => "Images/honor/honorx7d.webp"],
            ["name" => "Honor X9d 5G 256GB + 12GB RAM", "price" => 46500, "image_path" => "Images/honor/honorx9d5g.webp"],
            ["name" => "Honor H400 256GB + 12GB RAM", "price" => 54000, "image_path" => "Images/honor/honorh400.jpg"],
            ["name" => "Honor H400 Pro 512GB + 12GB RAM", "price" => 76000, "image_path" => "Images/honor/honorh400pro.jpg"],
        ];

        foreach ($honors as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
