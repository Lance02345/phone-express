<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class OppoSeeder extends Seeder
{
    public function run(): void
    {
        $oppos = [
            // RENO 15 SERIES
            [
                "name" => "Oppo Reno 15 Pro 5G 512GB + 12GB RAM",
                "price" => 76300,
                "image_path" => "Images/oppo/reno15pro.jpg"
            ],
            [
                "name" => "Oppo Reno 15 5G 512GB + 12GB RAM",
                "price" => 67500,
                "image_path" => "Images/oppo/reno15.jpg"
            ],
            [
                "name" => "Oppo Reno 15F 5G 512GB + 12GB RAM",
                "price" => 54700,
                "image_path" => "Images/oppo/reno15f.jpg"
            ],

            // RENO 14 / 12 / 11 SERIES
            [
                "name" => "Oppo Reno 14F 5G 512GB + 12GB RAM",
                "price" => 54300,
                "image_path" => "Images/oppo/reno14f.jpg"
            ],
            [
                "name" => "Oppo Reno 12F 5G 256GB + 12GB RAM",
                "price" => 37500,
                "image_path" => "Images/oppo/reno12f.jpg"
            ],
            [
                "name" => "Oppo Reno 12F 4G 256GB + 12GB RAM",
                "price" => 29000,
                "image_path" => "Images/oppo/reno12f.jpg" // reused image
            ],
            [
                "name" => "Oppo Reno 11F 5G 256GB + 8GB RAM",
                "price" => 40300,
                "image_path" => "Images/oppo/reno11f.jpg"
            ],

            // A6 SERIES
            [
                "name" => "Oppo A6 Pro 4G 256GB + 8GB RAM",
                "price" => 33700,
                "image_path" => "Images/oppo/a6pro.jpg"
            ],
            [
                "name" => "Oppo A6 Pro 5G 256GB + 8GB RAM",
                "price" => 38700,
                "image_path" => "Images/oppo/a6pro.jpg" // reused image
            ],

            // A5 SERIES
            [
                "name" => "Oppo A5 256GB + 8GB RAM",
                "price" => 25300,
                "image_path" => "Images/oppo/a5.jpg"
            ],
            [
                "name" => "Oppo A5 128GB + 6GB RAM",
                "price" => 20700,
                "image_path" => "Images/oppo/a5.jpg" // reused image
            ],

            // A3 SERIES
            [
                "name" => "Oppo A3 256GB + 8GB RAM",
                "price" => 28700,
                "image_path" => "Images/oppo/a3.jpg"
            ],
            [
                "name" => "Oppo A3 128GB + 6GB RAM",
                "price" => 23300,
                "image_path" => "Images/oppo/a3.jpg" // reused image
            ],

            // A38 SERIES
            [
                "name" => "Oppo A38 128GB + 6GB RAM",
                "price" => 22300,
                "image_path" => "Images/oppo/a38.jpg"
            ],
            [
                "name" => "Oppo A38 128GB + 4GB RAM",
                "price" => 19800,
                "image_path" => "Images/oppo/a38.jpg" // reused image
            ],

            // A6x SERIES
            [
                "name" => "Oppo A6x 256GB + 4GB RAM",
                "price" => 20300,
                "image_path" => "Images/oppo/a6x.jpg"
            ],
            [
                "name" => "Oppo A6x 128GB + 4GB RAM",
                "price" => 16300,
                "image_path" => "Images/oppo/a6x.jpg" // reused image
            ],
            [
                "name" => "Oppo A6x 64GB + 4GB RAM",
                "price" => 14700,
                "image_path" => "Images/oppo/a6x.jpg" // reused image
            ],

            // A3x
            [
                "name" => "Oppo A3x 128GB + 4GB RAM",
                "price" => 17300,
                "image_path" => "Images/oppo/a3x.jpg"
            ],
        ];

        foreach ($oppos as $phone) {
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
