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
            ["name" => "Oppo Reno 15 Pro 5G 512GB + 12GB RAM", "price" => 76300, "image_path" => "Images/oppo/reno15pro.jpg"],
            ["name" => "Oppo Reno 15 5G 512GB + 12GB RAM", "price" => 67000, "image_path" => "Images/oppo/reno15.jpg"],
            ["name" => "Oppo Reno 15F 5G 512GB + 12GB RAM", "price" => 56000, "image_path" => "Images/oppo/reno15f.jpg"],

            // RENO 14 / 12 / 11 SERIES
            ["name" => "Oppo Reno 14F 5G 512GB + 12GB RAM", "price" => 54000, "image_path" => "Images/oppo/reno14f.jpg"],
            ["name" => "Oppo Reno 12F 5G 256GB + 12GB RAM", "price" => 38300, "image_path" => "Images/oppo/reno12f.jpg"],
            ["name" => "Oppo Reno 12F 4G 256GB + 12GB RAM", "price" => 29200, "image_path" => "Images/oppo/reno12f.jpg"],
            ["name" => "Oppo Reno 11F 5G 256GB + 8GB RAM", "price" => 40300, "image_path" => "Images/oppo/reno11f.jpg"],

            // A6 SERIES
            ["name" => "Oppo A6 Pro 4G 256GB + 8GB RAM", "price" => 44000, "image_path" => "Images/oppo/a6pro.jpg"],
            ["name" => "Oppo A6 Pro 5G 256GB + 8GB RAM", "price" => 47000, "image_path" => "Images/oppo/a6pro.jpg"],
            ["name" => "Oppo A6 256GB + 8GB RAM", "price" => 36000, "image_path" => "Images/oppo/a6.jpg"],
            ["name" => "Oppo A6 256GB + 6GB RAM", "price" => 34000, "image_path" => "Images/oppo/a6.jpg"],

            // A5 SERIES
            ["name" => "Oppo A5 256GB + 8GB RAM", "price" => 25300, "image_path" => "Images/oppo/a5.jpg"],
            ["name" => "Oppo A5 128GB + 6GB RAM", "price" => 24000, "image_path" => "Images/oppo/a5.jpg"],

            // A3 SERIES
            ["name" => "Oppo A3 256GB + 8GB RAM", "price" => 28300, "image_path" => "Images/oppo/a3.jpg"],
            ["name" => "Oppo A3 128GB + 6GB RAM", "price" => 23300, "image_path" => "Images/oppo/a3.jpg"],

            // A38 SERIES
            ["name" => "Oppo A38 128GB + 4GB RAM", "price" => 20400, "image_path" => "Images/oppo/a38.jpg"],

            // A6x SERIES
            ["name" => "Oppo A6x 256GB + 4GB RAM", "price" => 25500, "image_path" => "Images/oppo/a6x.jpg"],
            ["name" => "Oppo A6x 128GB + 4GB RAM", "price" => 23000, "image_path" => "Images/oppo/a6x.jpg"],
            ["name" => "Oppo A6x 64GB + 4GB RAM", "price" => 20500, "image_path" => "Images/oppo/a6x.jpg"],

            // A3x SERIES
            ["name" => "Oppo A3x 128GB + 4GB RAM", "price" => 15700, "image_path" => "Images/oppo/a3x.jpg"],
        ];

        foreach ($oppos as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
