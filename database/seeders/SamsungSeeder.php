<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class SamsungSeeder extends Seeder
{
    public function run(): void
    {
        $samsungs = [
            // BRAND NEW EAST AFRICA STOCK
            ["name" => "Samsung Galaxy S26 Ultra 5G 256GB (East Africa)", "price" => 124000, "image_path" => "Images/samsung/samsungs24ultrae.jpg"],
            ["name" => "Samsung Galaxy S26 Ultra 5G 512GB (East Africa)", "price" => 154000, "image_path" => "Images/samsung/samsungs24ultrae.jpg"],
            ["name" => "Samsung Galaxy S25 Ultra 5G 512GB (East Africa)", "price" => 130000, "image_path" => "Images/samsung/samsungs24ultrae.jpg"],
            ["name" => "Samsung Galaxy A57 256GB + 8GB RAM (East Africa)", "price" => 52000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A57 128GB + 8GB RAM (East Africa)", "price" => 45000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A37 256GB + 8GB RAM (East Africa)", "price" => 42000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A56 256GB + 8GB RAM (East Africa)", "price" => 48000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A27 5G 128GB + 6GB RAM (East Africa)", "price" => 32000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A27 5G 256GB + 8GB RAM (East Africa)", "price" => 38000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A17 256GB + 8GB RAM (East Africa)", "price" => 33000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A17 128GB + 4GB RAM (East Africa)", "price" => 21500, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A16 128GB + 4GB RAM (East Africa)", "price" => 18500, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A07 128GB + 4GB RAM (East Africa)", "price" => 17500, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy Tab A11 64GB (East Africa)", "price" => 18500, "image_path" => "Images/samsung/samsungs24.jpg"],

            // BRAND NEW DUBAI STOCK
            ["name" => "Samsung Galaxy Fold 7 5G 256GB (Dubai)", "price" => 170000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy S25 Ultra 5G 256GB (Dubai)", "price" => 110000, "image_path" => "Images/samsung/samsungs24ultrae.jpg"],
            ["name" => "Samsung Galaxy A56 256GB + 8GB RAM (Dubai)", "price" => 47500, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A36 128GB + 8GB RAM (Dubai)", "price" => 35000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A26 128GB + 6GB RAM (Dubai)", "price" => 28500, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A17 128GB + 4GB RAM (Dubai)", "price" => 20500, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A17 128GB + 6GB RAM (Dubai)", "price" => 25000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A17 256GB + 8GB RAM (Dubai)", "price" => 28500, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy A16 128GB + 4GB RAM (Dubai)", "price" => 18500, "image_path" => "Images/samsung/samsungs24.jpg"],

            // NOTE SERIES
            ["name" => "Samsung Galaxy Note 10 5G 256GB", "price" => 26000, "image_path" => "Images/samsung/samsungnote10.jpg"],
            ["name" => "Samsung Galaxy Note 10+ 5G 256GB", "price" => 33000, "image_path" => "Images/samsung/samsungnote10plus.jpg"],
            ["name" => "Samsung Galaxy Note 20 5G 128GB", "price" => 28000, "image_path" => "Images/samsung/samsungnote20.jpg"],
            ["name" => "Samsung Galaxy Note 20 5G 256GB", "price" => 32000, "image_path" => "Images/samsung/samsungnote20.jpg"],
            ["name" => "Samsung Galaxy Note 20 Ultra 5G 128GB", "price" => 39000, "image_path" => "Images/samsung/samsungnote20ultra.jpg"],
            ["name" => "Samsung Galaxy Note 20 Ultra 5G 256GB", "price" => 43000, "image_path" => "Images/samsung/samsungnote20ultra.jpg"],

            // S20 SERIES
            ["name" => "Samsung Galaxy S20 5G 128GB", "price" => 23000, "image_path" => "Images/samsung/samsungs20.jpg"],
            ["name" => "Samsung Galaxy S20+ 5G 128GB", "price" => 25000, "image_path" => "Images/samsung/samsungs20.jpg"],
            ["name" => "Samsung Galaxy S20 Ultra 5G 128GB", "price" => 27500, "image_path" => "Images/samsung/samsungs20.jpg"],
            ["name" => "Samsung Galaxy S20FE 5G 128GB", "price" => 22000, "image_path" => "Images/samsung/samsungs20fe.jpg"],

            // S21 SERIES
            ["name" => "Samsung Galaxy S21 5G 128GB", "price" => 26500, "image_path" => "Images/samsung/samsungs21.jpg"],
            ["name" => "Samsung Galaxy S21 5G 256GB", "price" => 28500, "image_path" => "Images/samsung/samsungs21.jpg"],
            ["name" => "Samsung Galaxy S21+ 5G 128GB", "price" => 28000, "image_path" => "Images/samsung/samsungs21plus.jpg"],
            ["name" => "Samsung Galaxy S21FE 5G 128GB", "price" => 25000, "image_path" => "Images/samsung/samsungs21fe.jpg"],
            ["name" => "Samsung Galaxy S21FE 5G 256GB", "price" => 27000, "image_path" => "Images/samsung/samsungs21fe.jpg"],
            ["name" => "Samsung Galaxy S21 Ultra 5G 128GB", "price" => 40000, "image_path" => "Images/samsung/samsungs21ultra.jpg"],
            ["name" => "Samsung Galaxy S21 Ultra 5G 256GB", "price" => 43000, "image_path" => "Images/samsung/samsungs21ultra.jpg"],

            // S22 SERIES
            ["name" => "Samsung Galaxy S22 5G 128GB", "price" => 32000, "image_path" => "Images/samsung/samsungs22.webp"],
            ["name" => "Samsung Galaxy S22 5G 256GB", "price" => 34000, "image_path" => "Images/samsung/samsungs22.webp"],
            ["name" => "Samsung Galaxy S22+ 5G 128GB", "price" => 35000, "image_path" => "Images/samsung/samsungs22plus.jpg"],
            ["name" => "Samsung Galaxy S22+ 5G 256GB", "price" => 40000, "image_path" => "Images/samsung/samsungs22plus.jpg"],
            ["name" => "Samsung Galaxy S22 Ultra 5G 128GB", "price" => 47000, "image_path" => "Images/samsung/samsungs22ultra.jpg"],
            ["name" => "Samsung Galaxy S22 Ultra 5G 256GB", "price" => 55000, "image_path" => "Images/samsung/samsungs22ultra.jpg"],
            ["name" => "Samsung Galaxy S22 Ultra 5G 512GB", "price" => 60000, "image_path" => "Images/samsung/samsungs22ultra.jpg"],

            // S23 SERIES
            ["name" => "Samsung Galaxy S23FE 5G 128GB", "price" => 35000, "image_path" => "Images/samsung/samsungs23fe.jpg"],
            ["name" => "Samsung Galaxy S23FE 5G 256GB", "price" => 38000, "image_path" => "Images/samsung/samsungs23fe.jpg"],
            ["name" => "Samsung Galaxy S23 5G 128GB", "price" => 40000, "image_path" => "Images/samsung/samsungs23.jpg"],
            ["name" => "Samsung Galaxy S23 5G 256GB", "price" => 43000, "image_path" => "Images/samsung/samsungs23.jpg"],
            ["name" => "Samsung Galaxy S23+ 5G 256GB", "price" => 47000, "image_path" => "Images/samsung/samsungs23plus.jpeg"],
            ["name" => "Samsung Galaxy S23 Ultra 5G 256GB", "price" => 67000, "image_path" => "Images/samsung/samsungs23ultra.jpg"],
            ["name" => "Samsung Galaxy S23 Ultra 5G 512GB", "price" => 70000, "image_path" => "Images/samsung/samsungs23ultra.jpg"],

            // S24 SERIES
            ["name" => "Samsung Galaxy S24 5G 128GB", "price" => 50000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy S24FE 5G 128GB", "price" => 44000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy S24 5G 256GB", "price" => 55000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy S24 5G 512GB", "price" => 60000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy S24+ 5G 256GB", "price" => 65000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy S24+ 5G 512GB", "price" => 67000, "image_path" => "Images/samsung/samsungs24.jpg"],
            ["name" => "Samsung Galaxy S24 Ultra 5G 256GB", "price" => 85000, "image_path" => "Images/samsung/samsungs24ultrae.jpg"],
            ["name" => "Samsung Galaxy S24 Ultra 5G 512GB", "price" => 90000, "image_path" => "Images/samsung/samsungs24ultrae.jpg"],

            // S25 SERIES
            ["name" => "Samsung Galaxy S25 5G 128GB", "price" => 60000, "image_path" => "Images/samsung/samsungs25.jpg"],
            ["name" => "Samsung Galaxy S25 5G 256GB", "price" => 65000, "image_path" => "Images/samsung/samsungs25.jpg"],
            ["name" => "Samsung Galaxy S25 5G 512GB", "price" => 70000, "image_path" => "Images/samsung/samsungs25.jpg"],
            ["name" => "Samsung Galaxy S25+ 5G 256GB", "price" => 70000, "image_path" => "Images/samsung/samsungs25plus.jpg"],
            ["name" => "Samsung Galaxy S25+ 5G 512GB", "price" => 75000, "image_path" => "Images/samsung/samsungs25plus.jpg"],
            ["name" => "Samsung Galaxy S25 Ultra 5G 256GB", "price" => 100000, "image_path" => "Images/samsung/samsungs25ultra.jpg"],
            ["name" => "Samsung Galaxy S25 Ultra 5G 512GB", "price" => 110000, "image_path" => "Images/samsung/samsungs25ultra.jpg"],

            // FLIP & FOLD SERIES
            ["name" => "Samsung Galaxy Flip 3 5G 128GB", "price" => 26000, "image_path" => "Images/samsung/samsungflip3.jpeg"],
            ["name" => "Samsung Galaxy Flip 4 5G 128GB", "price" => 30000, "image_path" => "Images/samsung/samsungflip4.jpeg"],
            ["name" => "Samsung Galaxy Fold 3 5G", "price" => 48000, "image_path" => "Images/samsung/samsungfold4.jpeg"],
            ["name" => "Samsung Galaxy Fold 4 5G 256GB", "price" => 63000, "image_path" => "Images/samsung/samsungfold4.jpeg"],
            ["name" => "Samsung Galaxy Fold 5 5G 256GB", "price" => 68000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy Fold 5 5G 512GB", "price" => 70000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy Fold 6 5G 256GB", "price" => 95000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy Fold 6 5G 512GB", "price" => 100000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy Fold 7 512GB", "price" => 157000, "image_path" => "Images/samsung/samsungfold5.jpg"],
        ];

        foreach ($samsungs as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
