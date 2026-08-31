<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class RedmiSeeder extends Seeder
{
    public function run(): void
    {
        $redmis = [
            // REDMI NOTE 15 PRO+ SERIES
            ["name" => "Redmi Note 15 Pro+ 5G 512GB + 12GB RAM", "price" => 63500, "image_path" => "Images/redmi/note15proplus.jpg"],
            ["name" => "Redmi Note 15 Pro+ 5G 256GB + 8GB RAM", "price" => 52800, "image_path" => "Images/redmi/note15proplus.jpg"],

            // REDMI NOTE 15 PRO SERIES
            ["name" => "Redmi Note 15 Pro 512GB + 12GB RAM", "price" => 0, "image_path" => "Images/redmi/note15pro.jpg"],
            ["name" => "Redmi Note 15 Pro 256GB + 8GB RAM", "price" => 0, "image_path" => "Images/redmi/note15pro.jpg"],

            // REDMI NOTE 15 SERIES
            ["name" => "Redmi Note 15 256GB + 8GB RAM", "price" => 31500, "image_path" => "Images/redmi/note15.jpg"],
            ["name" => "Redmi Note 15 128GB + 6GB RAM", "price" => 28200, "image_path" => "Images/redmi/note15.jpg"],

            // REDMI 15 SERIES
            ["name" => "Redmi 15 256GB + 8GB RAM", "price" => 0, "image_path" => "Images/redmi/redmi15.jpg"],
            ["name" => "Redmi 15 128GB + 6GB RAM", "price" => 19800, "image_path" => "Images/redmi/redmi15.jpg"],

            // REDMI 15C SERIES
            ["name" => "Redmi 15C 256GB + 8GB RAM", "price" => 22500, "image_path" => "Images/redmi/redmi15c.jpg"],
            ["name" => "Redmi 15C 256GB + 4GB RAM", "price" => 19500, "image_path" => "Images/redmi/redmi15c.jpg"],
            ["name" => "Redmi 15C 128GB + 4GB RAM", "price" => 18600, "image_path" => "Images/redmi/redmi15c.jpg"],

            // REDMI A7 SERIES
            ["name" => "Redmi A7 128GB + 4GB RAM", "price" => 0, "image_path" => "Images/redmi/redmia7.webp"],
            ["name" => "Redmi A7 Pro 64GB + 4GB RAM", "price" => 14500, "image_path" => "Images/redmi/redmia7pro.png"],
            ["name" => "Redmi A7 64GB + 3GB RAM", "price" => 13600, "image_path" => "Images/redmi/redmia7.webp"],

            // TABLETS
            ["name" => "Redmi Pad SE 8.7\" 128GB + 4GB RAM", "price" => 0, "image_path" => "Images/redmi/redmipadse.jpg"],
            ["name" => "Redmi Pad 2 4G 128GB + 4GB RAM", "price" => 0, "image_path" => "Images/redmi/redmipad2.jpg"],
            ["name" => "Redmi Pad 2 4G 256GB + 8GB RAM", "price" => 0, "image_path" => "Images/redmi/redmipad2.jpg"],
        ];

        foreach ($redmis as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
