<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\View\View;

class PhoneController extends Controller
{
    public function show(Phone $phone): View
    {
        $brand = $this->brandFrom($phone->name);
        $storage = $this->storageFrom($phone->name);
        $searchTerm = $brand === 'Apple' ? 'iPhone' : $brand;

        $relatedPhones = Phone::query()
            ->search($searchTerm)
            ->whereKeyNot($phone->getKey())
            ->where('price', '>', 0)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $upfront = $phone->price > 0 ? (int) ceil($phone->price * 0.4) : null;
        $weekly = $upfront
            ? (int) ceil((($phone->price - $upfront) * 1.5) / 12)
            : null;

        return view('pages.phone-show', [
            'phone' => $phone,
            'brand' => $brand,
            'storage' => $storage,
            'imageAvailable' => filled($phone->image_path) && is_file(public_path($phone->image_path)),
            'relatedPhones' => $relatedPhones,
            'upfront' => $upfront,
            'weekly' => $weekly,
            'whatsappUrl' => 'https://wa.me/254721920545?text='.urlencode("Hello, I am interested in {$phone->name}"),
        ]);
    }

    private function brandFrom(string $name): string
    {
        return match (true) {
            str_contains(strtolower($name), 'iphone') => 'Apple',
            str_starts_with($name, 'Google Pixel') => 'Google',
            default => str($name)->before(' ')->toString(),
        };
    }

    private function storageFrom(string $name): ?string
    {
        preg_match('/\b(\d+)\s?(GB|TB)\b/i', $name, $matches);

        return isset($matches[1], $matches[2])
            ? $matches[1].strtoupper($matches[2])
            : null;
    }
}
