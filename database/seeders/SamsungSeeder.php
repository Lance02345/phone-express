<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class SamsungSeeder extends Seeder
{
    public function run(): void
    {
        $samsungs = [
            // NOTE SERIES
            ["name" => "Samsung Galaxy Note 10 5G 256GB", "price" => 31000, "image_path" => "Images/samsung/samsungnote10.jpg"],
            ["name" => "Samsung Galaxy Note 10+ 5G 256GB", "price" => 33000, "image_path" => "Images/samsung/samsungnote10plus.jpg"],
            ["name" => "Samsung Galaxy Note 20 5G 128GB", "price" => 29000, "image_path" => "Images/samsung/samsungnote20.jpg"],
            ["name" => "Samsung Galaxy Note 20 Ultra 5G 128GB", "price" => 40000, "image_path" => "Images/samsung/samsungnote20ultra.jpg"],
            ["name" => "Samsung Galaxy Note 20 Ultra 5G 256GB", "price" => 45000, "image_path" => "Images/samsung/samsungnote20ultra.jpg"],

            // S20 SERIES
            ["name" => "Samsung Galaxy S20 5G 128GB", "price" => 23000, "image_path" => "Images/samsung/samsungs20.jpg"],
            ["name" => "Samsung Galaxy S20FE 5G 128GB", "price" => 22000, "image_path" => "Images/samsung/samsungs20fe.jpg"],
            ["name" => "Samsung Galaxy S20+ 5G 128GB", "price" => 25000, "image_path" => "Images/samsung/samsungs20.jpg"], // REUSED IMAGE

            // S21 SERIES
            ["name" => "Samsung Galaxy S21 5G 128GB", "price" => 28000, "image_path" => "Images/samsung/samsungs21.jpg"],
            ["name" => "Samsung Galaxy S21 5G 256GB", "price" => 30000, "image_path" => "Images/samsung/samsungs21.jpg"], // REUSED IMAGE
            ["name" => "Samsung Galaxy S21+ 5G 128GB", "price" => 28000, "image_path" => "Images/samsung/samsungs21plus.jpg"],
            ["name" => "Samsung Galaxy S21FE 5G 128GB", "price" => 25000, "image_path" => "Images/samsung/samsungs21fe.jpg"],
            ["name" => "Samsung Galaxy S21 Ultra 5G 128GB", "price" => 40000, "image_path" => "Images/samsung/samsungs21ultra.jpg"],

            // S22 SERIES
            ["name" => "Samsung Galaxy S22 5G 128GB", "price" => 32000, "image_path" => "Images/samsung/samsungs22.webp"],
            ["name" => "Samsung Galaxy S22 5G 256GB", "price" => 34000, "image_path" => "Images/samsung/samsungs22.webp"],
            ["name" => "Samsung Galaxy S22+ 5G 128GB", "price" => 38000, "image_path" => "Images/samsung/samsungs22plus.jpg"],
            ["name" => "Samsung Galaxy S22+ 5G 256GB", "price" => 40000, "image_path" => "Images/samsung/samsungs22plus.jpg"],
            ["name" => "Samsung Galaxy S22 Ultra 5G 128GB", "price" => 50000, "image_path" => "Images/samsung/samsungs22ultra.jpg"],
            ["name" => "Samsung Galaxy S22 Ultra 5G 256GB", "price" => 58000, "image_path" => "Images/samsung/samsungs22ultra.jpg"],
            ["name" => "Samsung Galaxy S22 Ultra 5G 512GB", "price" => 60000, "image_path" => "Images/samsung/samsungs22ultra.jpg"], // REUSED IMAGE

            // S23 SERIES
            ["name" => "Samsung Galaxy S23FE 5G 128GB", "price" => 38000, "image_path" => "Images/samsung/samsungs23fe.jpg"],
            ["name" => "Samsung Galaxy S23 5G 128GB", "price" => 41000, "image_path" => "Images/samsung/samsungs23.jpg"],
            ["name" => "Samsung Galaxy S23 5G 256GB", "price" => 45000, "image_path" => "Images/samsung/samsungs23.jpg"], // REUSED IMAGE
            ["name" => "Samsung Galaxy S23+ 5G 256GB", "price" => 53000, "image_path" => "Images/samsung/samsungs23plus.jpeg"],
            ["name" => "Samsung Galaxy S23 Ultra 5G 256GB", "price" => 70000, "image_path" => "Images/samsung/samsungs23ultra.jpg"],
            ["name" => "Samsung Galaxy S23 Ultra 5G 512GB", "price" => 75000, "image_path" => "Images/samsung/samsungs23ultra.jpg"],

            // S24 SERIES
            ["name" => "Samsung Galaxy S24 5G 128GB", "price" => 50000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy S24+ 5G 256GB", "price" => 65000, "image_path" => "Images/samsung/samsungs24.jpg"], // REUSED IMAGE
            ["name" => "Samsung Galaxy S24 Ultra 5G 256GB", "price" => 88000, "image_path" => "Images/samsung/samsungs24ultra256.jpg"],
            ["name" => "Samsung Galaxy S24 Ultra 5G 512GB", "price" => 92000, "image_path" => "Images/samsung/samsungs24ultra256.jpg"], // REUSED IMAGE

            // FLIP & FOLD SERIES
            ["name" => "Samsung Galaxy Flip 3 5G 128GB", "price" => 32000, "image_path" => "Images/samsung/samsungflip3.jpeg"],
            ["name" => "Samsung Galaxy Flip 4 5G 128GB", "price" => 39000, "image_path" => "Images/samsung/samsungflip4.jpeg"],
            ["name" => "Samsung Galaxy Fold 4 5G 256GB", "price" => 75000, "image_path" => "Images/samsung/samsungfold4.jpeg"],
            ["name" => "Samsung Galaxy Fold 5 5G 256GB", "price" => 97000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy Fold 5 5G 512GB", "price" => 100000, "image_path" => "Images/samsung/samsungfold5.jpg"],
        ];

        foreach ($samsungs as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
