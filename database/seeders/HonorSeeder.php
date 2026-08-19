<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class HonorSeeder extends Seeder
{
    public function run(): void
    {
        $honors = [
            ["name" => "Honor Play 10 64GB + 3GB RAM", "price" => 0, "image_path" => null],
            ["name" => "Honor X5c 64GB + 4GB RAM", "price" => 14400, "image_path" => null],
            ["name" => "Honor X5c Plus 128GB + 4GB RAM", "price" => 15700, "image_path" => null],
            ["name" => "Honor X6c 128GB + 6GB RAM", "price" => 19800, "image_path" => null],
            ["name" => "Honor X6c 256GB + 6GB RAM", "price" => 22100, "image_path" => null],
            ["name" => "Honor X7d 256GB + 8GB RAM", "price" => 24400, "image_path" => null],
            ["name" => "Honor X9d 5G 256GB + 12GB RAM", "price" => 52300, "image_path" => null],
            ["name" => "Honor H400 256GB + 12GB RAM", "price" => 54000, "image_path" => null],
        ];

        foreach ($honors as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );
        }
    }
}
