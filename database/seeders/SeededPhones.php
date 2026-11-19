<?php

namespace Database\Seeders;

use App\Models\Phone;

/**
 * Saves the phones a seeder lists and remembers their names, so a full `db:seed` can hide
 * catalogue variants whose row has since been removed from every seeder.
 */
class SeededPhones
{
    /** @var array<string, true> */
    private static array $names = [];

    /**
     * @param  array<int, array{name: string, price: int, image_path: string}>  $phones
     */
    public static function save(array $phones): void
    {
        foreach ($phones as $phone) {
            Phone::updateOrCreate(
                ['name' => $phone['name']],
                ['price' => $phone['price'], 'image_path' => $phone['image_path']]
            );

            self::$names[$phone['name']] = true;
        }
    }

    /**
     * @return array<int, string>
     */
    public static function names(): array
    {
        return array_keys(self::$names);
    }
}
