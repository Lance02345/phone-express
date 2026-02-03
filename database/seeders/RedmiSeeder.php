<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class RedmiSeeder extends Seeder
{
    public function run(): void
    {
        $redmis = [
            // REDMI NOTE 15 SERIES (PRICES NOT PROVIDED)
            [
                "name" => "Redmi Note 15 Pro+ 5G 512GB + 12GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/note15proplus.jpg"
            ],
            [
                "name" => "Redmi Note 15 Pro+ 5G 256GB + 8GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/note15proplus.jpg"
            ],
            [
                "name" => "Redmi Note 15 Pro 512GB + 12GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/note15pro.jpg"
            ],
            [
                "name" => "Redmi Note 15 Pro 256GB + 8GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/note15pro.jpg"
            ],
            [
                "name" => "Redmi Note 15 256GB + 8GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/note15.jpg"
            ],
            [
                "name" => "Redmi Note 15 128GB + 6GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/note15.jpg"
            ],

            // REDMI 15 SERIES
            [
                "name" => "Redmi 15 256GB + 8GB RAM",
                "price" => 20500,
                "image_path" => "Images/redmi/redmi15.jpg"
            ],
            [
                "name" => "Redmi 15 128GB + 6GB RAM",
                "price" => 18700,
                "image_path" => "Images/redmi/redmi15.jpg"
            ],
            [
                "name" => "Redmi 15 128GB + 6GB RAM (Alt Price)",
                "price" => 18500,
                "image_path" => "Images/redmi/redmi15.jpg"
            ],
            [
                "name" => "Redmi 15 256GB (Alt Variant)",
                "price" => 19700,
                "image_path" => "Images/redmi/redmi15.jpg"
            ],

            // REDMI 15C SERIES
            [
                "name" => "Redmi 15C 256GB + 8GB RAM",
                "price" => 17500,
                "image_path" => "Images/redmi/redmi15c.jpg"
            ],
            [
                "name" => "Redmi 15C 128GB + 6GB RAM",
                "price" => 15000,
                "image_path" => "Images/redmi/redmi15c.jpg"
            ],
            [
                "name" => "Redmi 15C 128GB + 4GB RAM",
                "price" => 13800,
                "image_path" => "Images/redmi/redmi15c.jpg"
            ],

            // REDMI A SERIES
            [
                "name" => "Redmi A5 128GB + 4GB RAM",
                "price" => 12500,
                "image_path" => "Images/redmi/redmia5.jpg"
            ],
            [
                "name" => "Redmi A5 64GB + 3GB RAM",
                "price" => 11800,
                "image_path" => "Images/redmi/redmia5.jpg"
            ],

            // NOTE 15 (ALT LIST)
            [
                "name" => "Redmi Note 15 128GB + 6GB RAM",
                "price" => 24500,
                "image_path" => "Images/redmi/note15.jpg"
            ],
            [
                "name" => "Redmi Note 15 256GB + 8GB RAM",
                "price" => 28700,
                "image_path" => "Images/redmi/note15.jpg"
            ],
            [
                "name" => "Redmi Note 15 Pro 256GB + 8GB RAM",
                "price" => 36500,
                "image_path" => "Images/redmi/note15pro.jpg"
            ],
            [
                "name" => "Redmi Note 15 Pro 512GB + 8GB RAM",
                "price" => 44000,
                "image_path" => "Images/redmi/note15pro.jpg"
            ],

            // TABLETS (PRICES NOT PROVIDED)
            [
                "name" => "Redmi Pad SE 8.7\" 128GB + 4GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/redmipadse.jpg"
            ],
            [
                "name" => "Redmi Pad 2 4G 128GB + 4GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/redmipad2.jpg"
            ],
            [
                "name" => "Redmi Pad 2 4G 256GB + 8GB RAM",
                "price" => null,
                "image_path" => "Images/redmi/redmipad2.jpg"
            ],
        ];

        foreach ($redmis as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                [
                    'price' => $phone['price'],
                    'image_path' => $phone['image_path']
                ]
            );
        }
    }
}
