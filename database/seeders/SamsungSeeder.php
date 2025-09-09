<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class SamsungSeeder extends Seeder
{
    public function run(): void
    {
        $samsungs = [
            ["name" => "Samsung Galaxy Note 10 5G 256GB", "price" => 31000, "image_path" => "Images/samsung/samsungnote10.jpg"],
            ["name" => "Samsung Galaxy Note 10+ 5G 256GB", "price" => 33500, "image_path" => "Images/samsung/samsungnote10plus.jpg"],
            ["name" => "Samsung Galaxy Note 20 5G 128GB", "price" => 34000, "image_path" => "Images/samsung/samsungnote20.jpg"],
            ["name" => "Samsung Galaxy Note 20 Ultra 5G 128GB", "price" => 47000, "image_path" => "Images/samsung/samsungnote20ultra.jpg"],
            ["name" => "Samsung Galaxy Note 20 Ultra 5G 256GB", "price" => 49000, "image_path" => "Images/samsung/samsungnote20ultra.jpg"],

            ["name" => "Samsung Galaxy S20 5G 128GB", "price" => 28000, "image_path" => "Images/samsung/samsungs20.jpg"],
            ["name" => "Samsung Galaxy S20FE 5G 128GB", "price" => 23500, "image_path" => "Images/samsung/samsungs20fe.jpg"],

            ["name" => "Samsung Galaxy S21 5G 128GB", "price" => 30000, "image_path" => "Images/samsung/samsungs21.jpg"],
            ["name" => "Samsung Galaxy S21+ 5G 128GB", "price" => 34000, "image_path" => "Images/samsung/samsungs21plus.jpg"],
            ["name" => "Samsung Galaxy S21FE 5G 128GB", "price" => 32000, "image_path" => "Images/samsung/samsungs21fe.jpg"],
            ["name" => "Samsung Galaxy S21 Ultra 5G 128GB", "price" => 43000, "image_path" => "Images/samsung/samsungs21ultra.jpg"],

            ["name" => "Samsung Galaxy S22 5G 128GB", "price" => 36500, "image_path" => "Images/samsung/samsungs22.webp"],
            ["name" => "Samsung Galaxy S22 5G 256GB", "price" => 38500, "image_path" => "Images/samsung/samsungs22.webp"],
            ["name" => "Samsung Galaxy S22+ 5G 128GB", "price" => 42000, "image_path" => "Images/samsung/samsungs22plus.jpg"],
            ["name" => "Samsung Galaxy S22+ 5G 256GB", "price" => 44000, "image_path" => "Images/samsung/samsungs22plus.jpg"],
            ["name" => "Samsung Galaxy S22 Ultra 5G 128GB", "price" => 57000, "image_path" => "Images/samsung/samsungs22ultra.jpg"],
            ["name" => "Samsung Galaxy S22 Ultra 5G 256GB", "price" => 62000, "image_path" => "Images/samsung/samsungs22ultra.jpg"],

            ["name" => "Samsung Galaxy S23FE 5G 128GB", "price" => 42000, "image_path" => "Images/samsung/samsungs23fe.jpg"],
            ["name" => "Samsung Galaxy S23 5G 128GB", "price" => 46000, "image_path" => "Images/samsung/samsungs23.jpg"],
            ["name" => "Samsung Galaxy S23+ 5G 256GB", "price" => 60000, "image_path" => "Images/samsung/samsungs23plus.jpeg"],
            ["name" => "Samsung Galaxy S23 Ultra 5G 256GB", "price" => 79000, "image_path" => "Images/samsung/samsungs23ultra.jpg"],
            ["name" => "Samsung Galaxy S23 Ultra 5G 512GB", "price" => 83000, "image_path" => "Images/samsung/samsungs23ultra.jpg"],

            ["name" => "Samsung Galaxy Flip 3 5G 128GB", "price" => 32000, "image_path" => "Images/samsung/samsungflip3.jpeg"],
            ["name" => "Samsung Galaxy Flip 4 5G 128GB", "price" => 39000, "image_path" => "Images/samsung/samsungflip4.jpeg"],

            ["name" => "Samsung Galaxy Fold 4 5G 256GB", "price" => 75000, "image_path" => "Images/samsung/samsungfold4.jpeg"],
            ["name" => "Samsung Galaxy Fold 5 5G 256GB", "price" => 97000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy Fold 5 5G 512GB", "price" => 100000, "image_path" => "Images/samsung/samsungfold5.jpg"],

            ["name" => "Samsung Galaxy S24 5G 128GB", "price" => 55000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy S24 Ultra 5G 512GB", "price" => 100000, "image_path" => "Images/samsung/samsungs24ultra.jpg"],
        ];

        foreach ($samsungs as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
