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
            ["name" => "Vivo Y05 64GB + 4GB RAM", "price" => 19500, "image_path" => "Images/vivo/vivoy05.jpg"],
            ["name" => "Vivo Y05 128GB + 4GB RAM", "price" => 21000, "image_path" => "Images/vivo/vivoy05.jpg"],
            ["name" => "Vivo Y11d 128GB + 4GB RAM", "price" => 23000, "image_path" => "Images/vivo/vivoy11d.jpg"],
            ["name" => "Vivo Y04 64GB + 4GB RAM", "price" => 14700, "image_path" => "Images/vivo/vivoy04.png"],
            ["name" => "Vivo Y04 128GB + 4GB RAM", "price" => 16400, "image_path" => "Images/vivo/vivoy04.png"],
            ["name" => "Vivo Y21d 128GB + 4GB RAM", "price" => 25500, "image_path" => "Images/vivo/vivoy21d.jpg"],
            ["name" => "Vivo Y21d 128GB + 6GB RAM", "price" => 26000, "image_path" => "Images/vivo/vivoy21d.jpg"],
            ["name" => "Vivo Y21d 256GB + 6GB RAM", "price" => 27000, "image_path" => "Images/vivo/vivoy21d.jpg"],
            ["name" => "Vivo Y31d 128GB + 4GB RAM", "price" => 27500, "image_path" => "Images/vivo/vivoy31d.jpg"],
            ["name" => "Vivo Y31d 128GB + 6GB RAM", "price" => 29400, "image_path" => "Images/vivo/vivoy31d.jpg"],
            ["name" => "Vivo Y31d 256GB + 6GB RAM", "price" => 33500, "image_path" => "Images/vivo/vivoy31d.jpg"],
            ["name" => "Vivo Y500 256GB + 6GB RAM", "price" => 42000, "image_path" => "Images/vivo/vivoy500.jpg"],
            ["name" => "Vivo Y500 256GB + 8GB RAM", "price" => 46500, "image_path" => "Images/vivo/vivoy500.jpg"],

            // V60 SERIES
            ["name" => "Vivo V60 Lite 4G 256GB + 8GB RAM", "price" => 32400, "image_path" => "Images/vivo/vivov60lite.jpg"],
            ["name" => "Vivo V60 Lite 5G 256GB + 12GB RAM", "price" => 39200, "image_path" => "Images/vivo/vivov60lite.jpg"],
            ["name" => "Vivo V60 5G 256GB + 12GB RAM", "price" => 57400, "image_path" => "Images/vivo/vivov60.png"],

            // V70 SERIES
            ["name" => "Vivo V70FE 256GB + 8GB RAM", "price" => 53000, "image_path" => "Images/vivo/vivov70fe.jpg"],
            ["name" => "Vivo V70FE 512GB + 8GB RAM", "price" => 62500, "image_path" => "Images/vivo/vivov70fe.jpg"],
            ["name" => "Vivo V70 5G 256GB + 8GB RAM", "price" => 74500, "image_path" => "Images/vivo/vivov70.png"],
            ["name" => "Vivo V70 5G 512GB + 12GB RAM", "price" => 87000, "image_path" => "Images/vivo/vivov70.png"],

            // X SERIES
            ["name" => "Vivo X300 Pro 512GB + 16GB RAM", "price" => 152000, "image_path" => "Images/vivo/vivox300pro.webp"],
        ];

        foreach ($vivos as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
