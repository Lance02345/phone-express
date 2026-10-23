<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;

class SamsungSeeder extends Seeder
{
    public function run(): void
    {
        $samsungs = [
            // BRAND NEW (12 MONTHS WARRANTY)
            ["name" => "Samsung Galaxy A17 128GB + 4GB RAM", "price" => 24500, "image_path" => "Images/samsung/samsunga17.jpg"],
            ["name" => "Samsung Galaxy A17 128GB + 6GB RAM", "price" => 28000, "image_path" => "Images/samsung/samsunga17.jpg"],
            ["name" => "Samsung Galaxy A17 4G 256GB + 8GB RAM", "price" => 34000, "image_path" => "Images/samsung/samsunga17.jpg"],
            ["name" => "Samsung Galaxy A17 5G 256GB + 8GB RAM", "price" => 37500, "image_path" => "Images/samsung/samsunga17.jpg"],
            ["name" => "Samsung Galaxy A26 128GB + 6GB RAM", "price" => 33000, "image_path" => "Images/samsung/samsunga26.jpg"],
            ["name" => "Samsung Galaxy A26 256GB + 8GB RAM", "price" => 38000, "image_path" => "Images/samsung/samsunga26.jpg"],
            ["name" => "Samsung Galaxy A27 128GB + 8GB RAM", "price" => 35000, "image_path" => "Images/samsung/samsunga27.jpg"],
            ["name" => "Samsung Galaxy A27 256GB + 8GB RAM", "price" => 39000, "image_path" => "Images/samsung/samsunga27.jpg"],
            ["name" => "Samsung Galaxy A36 256GB + 8GB RAM", "price" => 40000, "image_path" => "Images/samsung/samsunga36.jpg"],
            ["name" => "Samsung Galaxy A56 256GB + 12GB RAM", "price" => 52000, "image_path" => "Images/samsung/samsunga56.jpg"],
            ["name" => "Samsung Galaxy S25FE 5G 128GB + 8GB RAM", "price" => 65000, "image_path" => "Images/samsung/samsungs25fe.jpg"],
            ["name" => "Samsung Galaxy S25FE 5G 256GB + 8GB RAM", "price" => 74000, "image_path" => "Images/samsung/samsungs25fe.jpg"],
            ["name" => "Samsung Galaxy S25 5G 256GB + 12GB RAM", "price" => 86000, "image_path" => "Images/samsung/samsungs25.jpg"],
            ["name" => "Samsung Galaxy S25 Edge 5G 256GB + 12GB RAM", "price" => 93000, "image_path" => "Images/samsung/samsungs25edge.jpg"],
            ["name" => "Samsung Galaxy S25 Ultra 5G 256GB + 12GB RAM", "price" => 109000, "image_path" => "Images/samsung/samsungs25ultra.jpg"],
            ["name" => "Samsung Galaxy S25 Ultra 5G 512GB + 12GB RAM", "price" => 120000, "image_path" => "Images/samsung/samsungs25ultra.jpg"],
            ["name" => "Samsung Galaxy S26FE 5G 256GB + 8GB RAM", "price" => 80000, "image_path" => "Images/samsung/samsungs26fe.jpg"],
            ["name" => "Samsung Galaxy S26 5G 256GB + 12GB RAM", "price" => 100000, "image_path" => "Images/samsung/samsungs26.jpg"],
            ["name" => "Samsung Galaxy S26+ 5G 256GB + 12GB RAM", "price" => 113000, "image_path" => "Images/samsung/samsungs26plus.jpg"],
            ["name" => "Samsung Galaxy S26 Ultra 5G 256GB + 12GB RAM", "price" => 126000, "image_path" => "Images/samsung/samsungs26ultra.jpg"],
            ["name" => "Samsung Galaxy S26 Ultra 5G 512GB + 12GB RAM", "price" => 151000, "image_path" => "Images/samsung/samsungs26ultra.jpg"],
            ["name" => "Samsung Galaxy Flip 5 5G 256GB + 8GB RAM", "price" => 68000, "image_path" => "Images/samsung/samsungflip5.jpg"],
            ["name" => "Samsung Galaxy Flip 6 5G 512GB + 12GB RAM", "price" => 90000, "image_path" => "Images/samsung/samsungflip6.jpg"],
            ["name" => "Samsung Galaxy Flip 8 5G 256GB + 12GB RAM", "price" => 115000, "image_path" => "Images/samsung/samsungflip8.jpg"],
            ["name" => "Samsung Galaxy Fold 5 5G 256GB + 12GB RAM", "price" => 130000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy Fold 5 5G 512GB + 12GB RAM", "price" => 145000, "image_path" => "Images/samsung/samsungfold5.jpg"],
            ["name" => "Samsung Galaxy Fold 6 5G 512GB + 12GB RAM", "price" => 165000, "image_path" => "Images/samsung/samsungfold6.jpg"],
            ["name" => "Samsung Galaxy Fold 7 5G 256GB + 12GB RAM", "price" => 161000, "image_path" => "Images/samsung/samsungfold7.jpg"],
            ["name" => "Samsung Galaxy Fold 7 5G 256GB + 12GB RAM (Mint)", "price" => 170000, "image_path" => "Images/samsung/samsungfold7.jpg"],
            ["name" => "Samsung Galaxy Fold 7 5G 512GB + 12GB RAM", "price" => 200000, "image_path" => "Images/samsung/samsungfold7.jpg"],
            ["name" => "Samsung Galaxy Fold 8 Wide 5G 256GB + 12GB RAM", "price" => 180000, "image_path" => "Images/samsung/samsungfold8wide.jpg"],
            ["name" => "Samsung Galaxy Fold 8 Wide 5G 512GB + 12GB RAM", "price" => 200000, "image_path" => "Images/samsung/samsungfold8wide.jpg"],
            ["name" => "Samsung Galaxy Fold 8 Ultra 5G 256GB + 12GB RAM", "price" => 195000, "image_path" => "Images/samsung/samsungfold8ultra.jpg"],
            ["name" => "Samsung Galaxy Fold 8 Ultra 5G 512GB + 12GB RAM", "price" => 214000, "image_path" => "Images/samsung/samsungfold8ultra.jpg"],

            // TABLETS
            ["name" => "Samsung Galaxy Tab A11 128GB + 6GB RAM (Cellular)", "price" => 28500, "image_path" => "Images/samsung/samsungtaba11.jpg"],
            ["name" => "Samsung Galaxy Tab A11 Plus 128GB + 6GB RAM (Cellular)", "price" => 34000, "image_path" => "Images/samsung/samsungtaba11plus.jpg"],
            ["name" => "Samsung Galaxy Tab A11 Plus 256GB + 8GB RAM (Cellular)", "price" => 50000, "image_path" => "Images/samsung/samsungtaba11plus.jpg"],
            ["name" => "Samsung Galaxy Tab S10 FE 128GB + 8GB RAM (WiFi)", "price" => 58000, "image_path" => "Images/samsung/samsungtabs10fe.jpg"],
            ["name" => "Samsung Galaxy Tab S10 FE 128GB + 8GB RAM (Cellular)", "price" => 62000, "image_path" => "Images/samsung/samsungtabs10fe.jpg"],
            ["name" => "Samsung Galaxy Tab S10 Ultra 256GB + 12GB RAM (WiFi)", "price" => 122000, "image_path" => "Images/samsung/samsungtabs10ultra.jpg"],
            ["name" => "Samsung Galaxy Tab S11 Ultra 256GB + 12GB RAM (WiFi)", "price" => 145000, "image_path" => "Images/samsung/samsungtabs11ultra.jpg"],
            ["name" => "Samsung Galaxy Tab S11 Ultra 256GB + 12GB RAM (Cellular)", "price" => 160000, "image_path" => "Images/samsung/samsungtabs11ultra.jpg"],

            // BUDS
            ["name" => "Samsung Galaxy Buds Core", "price" => 5500, "image_path" => "Images/samsung/samsungbudscore.jpg"],
            ["name" => "Samsung Galaxy Buds3 FE", "price" => 12000, "image_path" => "Images/samsung/samsungbuds3fe.jpg"],
            ["name" => "Samsung Galaxy Buds3 Pro", "price" => 18500, "image_path" => "Images/samsung/samsungbuds3pro.jpg"],
            ["name" => "Samsung Galaxy Buds4", "price" => 18000, "image_path" => "Images/samsung/samsungbuds4.jpg"],
            ["name" => "Samsung Galaxy Buds4 Pro", "price" => 25000, "image_path" => "Images/samsung/samsungbuds4pro.jpg"],

            // WATCHES
            ["name" => "Samsung Galaxy Watch8 40mm", "price" => 26500, "image_path" => "Images/samsung/samsungwatch8.jpg"],
            ["name" => "Samsung Galaxy Watch8 44mm", "price" => 30000, "image_path" => "Images/samsung/samsungwatch8.jpg"],
            ["name" => "Samsung Galaxy Watch8 Classic 46mm", "price" => 36000, "image_path" => "Images/samsung/samsungwatch8classic.jpg"],

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
            ["name" => "Samsung Galaxy Fold 6 5G 256GB", "price" => 95000, "image_path" => "Images/samsung/samsungfold6.jpg"],
            ["name" => "Samsung Galaxy Fold 6 5G 512GB", "price" => 100000, "image_path" => "Images/samsung/samsungfold6.jpg"],
            ["name" => "Samsung Galaxy Fold 7 512GB", "price" => 157000, "image_path" => "Images/samsung/samsungfold7.jpg"],
        ];

        foreach ($samsungs as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
