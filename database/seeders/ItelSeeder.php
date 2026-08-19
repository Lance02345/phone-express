<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class ItelSeeder extends Seeder
{
    public function run(): void
    {
        $itels = [
            ["name" => "Itel S26 Ultra 256GB + 8GB RAM", "price" => 24900, "image_path" => null],
            ["name" => "Itel City 200 128GB + 4GB RAM", "price" => 16800, "image_path" => null],
            ["name" => "Itel A200 4G 128GB + 4GB RAM", "price" => 0, "image_path" => null],
            ["name" => "Itel A100C 64GB + 2GB RAM", "price" => 12000, "image_path" => null],
            ["name" => "Itel A06 64GB + 2GB RAM", "price" => 10500, "image_path" => null],
        ];

        foreach ($itels as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
