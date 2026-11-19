<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
{
    public function run(): void
    {
        $phones = [
            ["name" => "iPhone X 256GB", "price" => 25000, "image_path" => "Images/iphone x.jpg"],
            ["name" => "iPhone XR 128GB", "price" => 28000, "image_path" => "Images/iphone xr.jpg"],
            ["name" => "iPhone 11 64GB", "price" => 29500, "image_path" => "Images/iphone 11.jpg"],
            ["name" => "iPhone 11 128GB", "price" => 33500, "image_path" => "Images/iphone 11.jpg"],
            ["name" => "iPhone 11 Pro 256GB", "price" => 41000, "image_path" => "Images/iphone11Pro.jpg"],
            ["name" => "iPhone 11 Pro 512GB", "price" => 43000, "image_path" => "Images/iphone11Pro.jpg"],
            ["name" => "iPhone 11 Pro Max 256GB", "price" => 48500, "image_path" => "Images/iphone11promax.jpg"],
            ["name" => "iPhone 11 Pro Max 512GB", "price" => 57000, "image_path" => "Images/iphone11promax.jpg"],
            ["name" => "iPhone 12 128GB", "price" => 43000, "image_path" => "Images/iphone12.jpg"],
            ["name" => "iPhone 12 256GB", "price" => 45000, "image_path" => "Images/iphone12.jpg"],
            ["name" => "iPhone 12 Pro 128GB", "price" => 49000, "image_path" => "Images/12pro.jpg"],
            ["name" => "iPhone 12 Pro 256GB", "price" => 50000, "image_path" => "Images/12pro.jpg"],
            ["name" => "iPhone 12 Pro 512GB", "price" => 54000, "image_path" => "Images/12pro.jpg"],
            ["name" => "iPhone 12 Pro Max 128GB", "price" => 57500, "image_path" => "Images/iphone12promax.jpg"],
            ["name" => "iPhone 12 Pro Max 256GB", "price" => 64000, "image_path" => "Images/iphone12promax.jpg"],
            ["name" => "iPhone 13 128GB", "price" => 48500, "image_path" => "Images/iphone13.jpg"],
            ["name" => "iPhone 13 256GB", "price" => 54000, "image_path" => "Images/iphone13.jpg"],
            ["name" => "iPhone 13 512GB", "price" => 59000, "image_path" => "Images/iphone13.jpg"],
            ["name" => "iPhone 13 mini 128GB", "price" => 43000, "image_path" => "Images/iphone13mini.jpg"],
            ["name" => "iPhone 13 Pro 128GB", "price" => 60000, "image_path" => "Images/ihone13pro.jpg"],
            ["name" => "iPhone 13 Pro 256GB", "price" => 67000, "image_path" => "Images/ihone13pro.jpg"],
            ["name" => "iPhone 13 Pro Max 128GB", "price" => 67000, "image_path" => "Images/iphone13promax.jpg"],
            ["name" => "iPhone 13 Pro Max 256GB", "price" => 70000, "image_path" => "Images/iphone13promax.jpg"],
            ["name" => "iPhone 13 Pro Max 512GB", "price" => 76500, "image_path" => "Images/iphone13promax.jpg"],
            ["name" => "iPhone 14 128GB", "price" => 80000, "image_path" => "Images/iphone14.jpg"],
            ["name" => "iPhone 14 256GB", "price" => 63000, "image_path" => "Images/iphone14.jpg"],
            ["name" => "iPhone 14 Pro 128GB", "price" => 79000, "image_path" => "Images/iphone14pro.jpg"],
            ["name" => "iPhone 14 Pro 256GB", "price" => 83000, "image_path" => "Images/iphone14pro.jpg"],
            ["name" => "iPhone 14 Pro 512GB", "price" => 87500, "image_path" => "Images/iphone14pro.jpg"],
            ["name" => "iPhone 14 Plus 256GB", "price" => 71000, "image_path" => "Images/iphone14plus.jpg"],
            ["name" => "iPhone 14 Pro Max 128GB", "price" => 86000, "image_path" => "Images/iphone14promax.jpg"],
            ["name" => "iPhone 14 Pro Max 256GB", "price" => 93000, "image_path" => "Images/iphone14promax.jpg"],
            ["name" => "iPhone 15 128GB", "price" => 82000, "image_path" => "Images/iphone15.jpg"],
            ["name" => "iPhone 15 Plus 128GB", "price" => 90000, "image_path" => "Images/iphone15plus.jpg"],
            ["name" => "iPhone 15 Pro 256GB", "price" => 103000, "image_path" => "Images/iphone15pro.jpg"],
            ["name" => "iPhone 16 128GB", "price" => 100000, "image_path" => "Images/iphone16.jpg"],
            ["name" => "iPhone 16 256GB", "price" => 117000, "image_path" => "Images/iphone16.jpg"],
            ["name" => "iPhone 16 Plus 128GB", "price" => 115000, "image_path" => "Images/iphone16plus.jpg"],
            ["name" => "iPhone 16 Pro 128GB", "price" => 137000, "image_path" => "Images/iphone16pro.jpg"],
            ["name" => "iPhone 16 Pro Max 256GB", "price" => 152500, "image_path" => "Images/iphone16promax.jpg"],
            ["name" => "iPhone 16 Pro Max 512GB", "price" => 180000, "image_path" => "Images/iphone16promax.jpg"],
            ["name" => "iPhone 16 Pro Max 256GB E-Sim", "price" => 150000, "image_path" => "Images/iphone16promax.jpg"],

            // iPhone 17 Series - Physical Sim models
            ["name" => "iPhone 17E 256GB", "price" => 106000, "image_path" => "Images/iphone17e.jpg"],
            ["name" => "iPhone 17 256GB", "price" => 123000, "image_path" => "Images/iphone17-black.jpg"],
            ["name" => "iPhone 17 Pro 256GB (Orange/Blue)", "price" => 162000, "image_path" => "Images/iphone17pro-orange.jpg"],
            ["name" => "iPhone 17 Pro 512GB", "price" => 184000, "image_path" => "Images/iphone17pro-orange.jpg"],
            ["name" => "iPhone 17 Pro Max 256GB (Silver)", "price" => 184000, "image_path" => "Images/iphone17promax-silver.jpg"],
            ["name" => "iPhone 17 Pro Max 256GB (Blue/Orange)", "price" => 174000, "image_path" => "Images/iphone17promax-blue.jpg"],
            ["name" => "iPhone 17 Pro Max 512GB (Silver)", "price" => 213000, "image_path" => "Images/iphone17promax-silver.jpg"],
            ["name" => "iPhone 17 Pro Max 512GB (Blue/Orange)", "price" => 205000, "image_path" => "Images/iphone17promax-blue.jpg"],
            ["name" => "iPhone 17 Pro Max 1TB", "price" => 237000, "image_path" => "Images/iphone17promax-orange.jpg"],

            // iPhone 17 Series - E-Sim Only models
            ["name" => "iPhone 17E 256GB E-Sim", "price" => 96000, "image_path" => "Images/iphone17e.jpg"],
            ["name" => "iPhone 17 256GB E-Sim", "price" => 122000, "image_path" => "Images/iphone17-black.jpg"],
            ["name" => "iPhone 17 Air 256GB E-Sim", "price" => 122000, "image_path" => "Images/iphone17-white.jpg"],
            ["name" => "iPhone 17 Pro 256GB E-Sim (Silver)", "price" => 153000, "image_path" => "Images/iphone17pro-silver.jpg"],
            ["name" => "iPhone 17 Pro 256GB E-Sim (Blue/Orange)", "price" => 151000, "image_path" => "Images/iphone17pro-blue.jpg"],
            ["name" => "iPhone 17 Pro 512GB E-Sim", "price" => 177000, "image_path" => "Images/iphone17pro-orange.jpg"],
            ["name" => "iPhone 17 Pro Max 256GB E-Sim (Silver)", "price" => 165000, "image_path" => "Images/iphone17promax-silver.jpg"],
            ["name" => "iPhone 17 Pro Max 256GB E-Sim (Blue/Orange)", "price" => 162000, "image_path" => "Images/iphone17promax-blue.jpg"],
            ["name" => "iPhone 17 Pro Max 512GB E-Sim (Silver)", "price" => 192000, "image_path" => "Images/iphone17promax-silver.jpg"],
            ["name" => "iPhone 17 Pro Max 512GB E-Sim (Blue/Orange)", "price" => 185000, "image_path" => "Images/iphone17promax-blue.jpg"],
            ["name" => "iPhone 17 Pro Max 1TB E-Sim", "price" => 208000, "image_path" => "Images/iphone17promax-orange.jpg"],

            // iPhone 18 Series - E-Sim Only models
            ["name" => "iPhone Duo 256GB E-Sim", "price" => 322000, "image_path" => "Images/iphoneduo.jpg"],
            ["name" => "iPhone Duo 512GB E-Sim", "price" => 355000, "image_path" => "Images/iphoneduo.jpg"],
            ["name" => "iPhone 18 Pro 256GB E-Sim", "price" => 176000, "image_path" => "Images/iphone18pro.jpg"],
            ["name" => "iPhone 18 Pro 512GB E-Sim", "price" => 208000, "image_path" => "Images/iphone18pro.jpg"],
            ["name" => "iPhone 18 Pro Max 256GB E-Sim (Burgundy)", "price" => 200000, "image_path" => "Images/iphone18promax-burgundy.jpg"],
            ["name" => "iPhone 18 Pro Max 256GB E-Sim (Glacier/Silver/Black)", "price" => 202000, "image_path" => "Images/iphone18promax-glacier.jpg"],
            ["name" => "iPhone 18 Pro Max 512GB E-Sim", "price" => 209000, "image_path" => "Images/iphone18promax.jpg"],
            ["name" => "iPhone 18 Pro Max 1TB E-Sim", "price" => 284000, "image_path" => "Images/iphone18promax.jpg"],

            // iPhone 18 Series - Physical Sim models
            ["name" => "iPhone 18 Pro 256GB (Burgundy)", "price" => 188000, "image_path" => "Images/iphone18pro-burgundy.jpg"],
            ["name" => "iPhone 18 Pro 256GB (Black)", "price" => 186000, "image_path" => "Images/iphone18pro-black.jpg"],
            ["name" => "iPhone 18 Pro 256GB (Glacier/Silver)", "price" => 185000, "image_path" => "Images/iphone18pro-glacier.jpg"],
            ["name" => "iPhone 18 Pro 512GB", "price" => 220000, "image_path" => "Images/iphone18pro.jpg"],
            ["name" => "iPhone 18 Pro Max 256GB (Burgundy)", "price" => 213000, "image_path" => "Images/iphone18promax-burgundy.jpg"],
            ["name" => "iPhone 18 Pro Max 256GB (Glacier/Silver/Black)", "price" => 211000, "image_path" => "Images/iphone18promax-glacier.jpg"],
            ["name" => "iPhone 18 Pro Max 512GB (Burgundy)", "price" => 242000, "image_path" => "Images/iphone18promax-burgundy.jpg"],
            ["name" => "iPhone 18 Pro Max 512GB (Glacier/Silver/Black)", "price" => 237000, "image_path" => "Images/iphone18promax-glacier.jpg"],
            ["name" => "iPhone 18 Pro Max 1TB", "price" => 310000, "image_path" => "Images/iphone18promax.jpg"],

            // MacBook Air Series - full payment only
            ["name" => "MacBook Air 13-inch M5 16GB RAM 512GB SSD", "price" => 200000, "image_path" => "Images/macs/mac air 13 m5.jpeg"],
            ["name" => "MacBook Air 13-inch M5 16GB RAM 1TB SSD", "price" => 205000, "image_path" => "Images/macs/mac air 13 m5.jpeg"],
            ["name" => "MacBook Air 13-inch M5 24GB RAM 1TB SSD", "price" => 273000, "image_path" => "Images/macs/mac air 13 m5.jpeg"],
            ["name" => "MacBook Air 15-inch M5 16GB RAM 512GB SSD", "price" => 213000, "image_path" => "Images/macs/mac air 15 m5.jpeg"],
            ["name" => "MacBook Air 15-inch M5 16GB RAM 1TB SSD", "price" => 253000, "image_path" => "Images/macs/mac air 15 m5.jpeg"],
            ["name" => "MacBook Air 15-inch M5 24GB RAM 1TB SSD", "price" => 278000, "image_path" => "Images/macs/mac air 15 m5.jpeg"],
            ["name" => "MacBook Neo 13-inch 8GB RAM 256GB SSD", "price" => 98000, "image_path" => "Images/macs/Apple MacBook Neo 13_ 2026 Silver 256 SDD 8GB [Open Box].jpeg"],
            ["name" => "MacBook Neo 13-inch 8GB RAM 512GB SSD", "price" => 113000, "image_path" => "Images/macs/Apple MacBook Neo 13_ 2026 Silver 256 SDD 8GB [Open Box].jpeg"],

            // MacBook Pro Series - full payment only
            ["name" => "MacBook Pro 16-inch M5 Max 48GB RAM 2TB SSD", "price" => 675000, "image_path" => "Images/macs/Macbook Pro Max M5 16 inch.jpeg"],
            ["name" => "MacBook Pro 16-inch M5 Max 36GB RAM 2TB SSD", "price" => 565000, "image_path" => "Images/macs/Macbook Pro Max M5 16 inch.jpeg"],
            ["name" => "MacBook Pro 16-inch M5 Pro 24GB RAM 1TB SSD", "price" => 415000, "image_path" => "Images/macs/Macbook Pro Max M5 16 inch.jpeg"],
            ["name" => "MacBook Pro 16-inch M5 Pro 48GB RAM 1TB SSD", "price" => 505000, "image_path" => "Images/macs/Macbook Pro Max M5 16 inch.jpeg"],
            ["name" => "MacBook Pro 14-inch M5 Max 36GB RAM 2TB SSD", "price" => 555000, "image_path" => "Images/macs/macbookpro14.jpeg"],
            ["name" => "MacBook Pro 14-inch M5 Pro 24GB RAM 1TB SSD", "price" => 340000, "image_path" => "Images/macs/macbookpro14.jpeg"],
            ["name" => "MacBook Pro 14-inch M5 Pro 24GB RAM 2TB SSD", "price" => 375000, "image_path" => "Images/macs/macbookpro14.jpeg"],
            ["name" => "MacBook Pro 14-inch M5 16GB RAM 512GB SSD", "price" => 270000, "image_path" => "Images/macs/macbookpro14.jpeg"],
            ["name" => "MacBook Pro 14-inch M5 16GB RAM 1TB SSD", "price" => 280000, "image_path" => "Images/macs/macbookpro14.jpeg"],
            ["name" => "MacBook Pro 14-inch M5 24GB RAM 1TB SSD", "price" => 310000, "image_path" => "Images/macs/macbookpro14.jpeg"],

            // Mac mini - full payment only
            ["name" => "Mac mini M4 16GB RAM 256GB SSD", "price" => 113500, "image_path" => "Images/macs/macminim4.jpg"],
            ["name" => "Mac mini M4 16GB RAM 512GB SSD", "price" => 170000, "image_path" => "Images/macs/macminim4.jpg"],
        ];


        SeededPhones::save($phones);
    }
}
