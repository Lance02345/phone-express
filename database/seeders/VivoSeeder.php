<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class VivoSeeder extends Seeder
{
    public function run(): void
    {
        $vivos = [
            // Y SERIES
            ["name" => "Vivo Y04 64GB + 4GB RAM", "price" => 14700, "image_path" => "Images/vivo/vivoy04.jpg"],
            ["name" => "Vivo Y04 128GB + 4GB RAM", "price" => 16400, "image_path" => "Images/vivo/vivoy04.jpg"],
            ["name" => "Vivo Y21d 128GB + 4GB RAM", "price" => 20600, "image_path" => "Images/vivo/vivoy21d.jpg"],
            ["name" => "Vivo Y21d 128GB + 6GB RAM", "price" => 21600, "image_path" => "Images/vivo/vivoy21d.jpg"],
            ["name" => "Vivo Y21d 256GB + 6GB RAM", "price" => 24000, "image_path" => "Images/vivo/vivoy21d.jpg"],
            ["name" => "Vivo Y31d 128GB + 6GB RAM", "price" => 25800, "image_path" => "Images/vivo/vivoy31d.jpg"],
            ["name" => "Vivo Y31d 256GB + 6GB RAM", "price" => 28200, "image_path" => "Images/vivo/vivoy31d.jpg"],

            // V60 SERIES
            ["name" => "Vivo V60 Lite 4G 256GB + 8GB RAM", "price" => 32400, "image_path" => "Images/vivo/vivov60lite.jpg"],
            ["name" => "Vivo V60 Lite 5G 256GB + 12GB RAM", "price" => 39200, "image_path" => "Images/vivo/vivov60lite.jpg"],
            ["name" => "Vivo V60 5G 256GB + 12GB RAM", "price" => 57400, "image_path" => "Images/vivo/vivov60.jpg"],

            // V70 SERIES
            ["name" => "Vivo V70FE 256GB + 8GB RAM", "price" => 54300, "image_path" => "Images/vivo/vivov70fe.jpg"],
            ["name" => "Vivo V70FE 512GB + 8GB RAM", "price" => 62300, "image_path" => "Images/vivo/vivov70fe.jpg"],
            ["name" => "Vivo V70 5G 256GB + 8GB RAM", "price" => 69300, "image_path" => "Images/vivo/vivov70.jpg"],
            ["name" => "Vivo V70 5G 512GB + 12GB RAM", "price" => 75400, "image_path" => "Images/vivo/vivov70.jpg"],

            // X SERIES
            ["name" => "Vivo X300 Pro 512GB + 16GB RAM", "price" => 155000, "image_path" => "Images/vivo/vivox300pro.jpg"],
        ];

        foreach ($vivos as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
