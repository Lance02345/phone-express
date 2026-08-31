<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class TecnoSeeder extends Seeder
{
    public function run(): void
    {
        $tecnos = [
            // PHANTOM V SERIES
            ["name" => "Tecno Phantom V Flip 2 5G AE11 256GB + 8GB RAM", "price" => 77000, "image_path" => "Images/tecno/phantomvflip2.png"],
            ["name" => "Tecno Phantom V Fold 2 5G AE10 512GB + 12GB RAM", "price" => 125000, "image_path" => "Images/tecno/phantomvfold2.jpg"],
            ["name" => "Tecno Phantom V Flip 5G AD11 256GB + 8GB RAM", "price" => 75500, "image_path" => "Images/tecno/phantomvflip.png"],
            ["name" => "Tecno Phantom V Fold 5G AD10 512GB + 12GB RAM", "price" => 133800, "image_path" => "Images/tecno/phantomvfold.png"],
            ["name" => "Tecno Phantom V Fold 5G AD10 256GB + 12GB RAM", "price" => 119500, "image_path" => "Images/tecno/phantomvfold.png"],

            // CAMON SERIES
            ["name" => "Tecno Camon 50 Pro CN5C 256GB + 8GB RAM", "price" => 42000, "image_path" => "Images/tecno/camon50pro.png"],
            ["name" => "Tecno Camon 50 CN5 256GB + 8GB RAM", "price" => 35000, "image_path" => "Images/tecno/camon50.png"],
            ["name" => "Tecno Camon 40 Pro CM6 256GB + 8GB RAM", "price" => 34500, "image_path" => "Images/tecno/camon40pro.jpg"],

            // SPARK SERIES
            ["name" => "Tecno Spark 30 Bumblebee KL6 128GB + 8GB RAM", "price" => 18200, "image_path" => "Images/tecno/spark30.jpg"],
            ["name" => "Tecno Spark Slim KM7k 256GB + 8GB RAM", "price" => 0, "image_path" => "Images/tecno/sparkslim.png"],
            ["name" => "Tecno Spark 40 Pro+ KM7 256GB + 8GB RAM", "price" => 26700, "image_path" => "Images/tecno/spark40proplus.webp"],
            ["name" => "Tecno Spark 40 Pro KM6 128GB + 8GB RAM", "price" => 0, "image_path" => "Images/tecno/spark40pro.jpg"],
            ["name" => "Tecno Spark 50 KM5 256GB + 4GB RAM", "price" => 21800, "image_path" => "Images/tecno/spark50.jpg"],
            ["name" => "Tecno Spark 50 KN4 128GB + 4GB RAM", "price" => 19500, "image_path" => "Images/tecno/spark50.jpg"],

            // POP SERIES
            ["name" => "Tecno Pop 20 KN3 128GB + 4GB RAM", "price" => 17200, "image_path" => "Images/tecno/pop20.png"],
            ["name" => "Tecno Pop 20 KN3 64GB + 4GB RAM", "price" => 15900, "image_path" => "Images/tecno/pop20.png"],
            ["name" => "Tecno Pop 10 KM4 64GB + 3GB RAM", "price" => 14100, "image_path" => "Images/tecno/pop10.jpg"],

            // MEGAPAD SERIES
            ["name" => "Tecno Megapad SE T1102 256GB + 8GB RAM", "price" => 0, "image_path" => "Images/tecno/megapad.png"],
            ["name" => "Tecno Megapad SE T1102 128GB + 4GB RAM", "price" => 0, "image_path" => "Images/tecno/megapad.png"],
        ];

        foreach ($tecnos as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
