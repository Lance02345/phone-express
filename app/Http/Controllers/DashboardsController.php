<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;
use Illuminate\Support\Facades\Cache;

class DashboardsController extends Controller
{
public function index()
{
    // Get popular phones for landing page - optimized with caching
    $cacheKey = 'landing_page_phones_' . date('Y-m-d'); // Cache for 24 hours
    $cacheDuration = now()->addHours(24);
    
    $phones = Cache::remember($cacheKey, $cacheDuration, function () {
        // Get phones with reasonable prices (not 0)
        return Phone::where('price', '>', 0)
            ->inRandomOrder()
            ->limit(12)
            ->get()
            ->map(function ($phone) {
                // Pre-calculate Lipa PolePole installments
                if (stripos($phone->name, 'iPhone') !== false) {
                    $phone->lipa_installment = ceil(($phone->price * 1.1) / 10); // 10% interest, 10 months
                }
                return $phone;
            });
    });
    
    // Split into two groups: 6 for full payment, 6 for Lipa PolePole
    $fullPhones = $phones->take(6);
    $lipaPhones = $phones->skip(6)->take(6);
    
    // Get phone categories with counts
    $categories = Cache::remember('phone_categories', 3600, function () {
        $iphoneCount = Phone::where('name', 'like', '%iPhone%')->where('price', '>', 0)->count();
        $samsungCount = Phone::where('name', 'like', '%Samsung%')->where('price', '>', 0)->count();
        
        return [
            'all' => Phone::where('price', '>', 0)->count(),
            'iphone' => $iphoneCount,
            'samsung' => $samsungCount,
            'android' => Phone::where('name', 'not like', '%iPhone%')->where('price', '>', 0)->count(),
        ];
    });
    
    // Get statistics for the landing page
    $statistics = [
        'phones_sold' => 10000 + rand(500, 1500), // Simulated with some randomness
        'happy_customers' => 25000 + rand(1000, 3000),
        'years_experience' => 8,
        'branches' => 2,
    ];
    
    return view('pages.landing', compact('fullPhones', 'lipaPhones', 'categories', 'statistics'));
}

}
