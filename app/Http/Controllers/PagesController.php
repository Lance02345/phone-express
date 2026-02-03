<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;

class PagesController extends Controller
{
    private const PRICE_RANGES = [
        '0-50000' => [1, 50000],
        '50000-80000' => [50000, 80000],
        '80000+' => [80000, null],
    ];

    private const BRAND_FILTERS = [
        'Apple' => ['iPhone'],
        'Samsung' => ['Samsung', 'Galaxy'],
    ];

    private const SORT_OPTIONS = [
        'newest' => ['field' => 'created_at', 'direction' => 'desc'],
        'price_asc' => ['field' => 'price', 'direction' => 'asc'],
        'price_desc' => ['field' => 'price', 'direction' => 'desc'],
        'name_asc' => ['field' => 'name', 'direction' => 'asc'],
        'name_desc' => ['field' => 'name', 'direction' => 'desc'],
    ];

    public function pricing(Request $request)
    {
        $query = Phone::query();
        
        // Apply filters in optimal order
        $this->applySearchFilter($query, $request);
        $this->applyBrandFilter($query, $request);
        $this->applyPriceFilter($query, $request);
        $this->applyStorageFilter($query, $request);
        
        // Payment method filter
        $paymentMethod = $request->get('payment_method', 'full');
        if ($paymentMethod === 'lipa') {
            $query->where('name', 'like', '%iPhone%');
        }
        
        // Apply sorting (most efficient to do last)
        $this->applySorting($query, $request);
        
        // Cache key for pagination
        $cacheKey = $this->generateCacheKey($request, $paymentMethod);
        
        // Get paginated results with optimized query
        $phones = $query->select(['id', 'name', 'price', 'image_path', 'created_at'])
                       ->withCasts(['price' => 'integer'])
                       ->paginate($this->getPerPage($request))
                       ->appends($request->except('page'));
        
        // Calculate Lipa Mdogo Mdogo prices in bulk
        if ($paymentMethod === 'lipa') {
            $this->calculateLipaPrices($phones);
        }
        
        // Prepare filters for view
        $filters = [
            'search' => $request->search,
            'brand' => $request->brand,
            'price_range' => $request->price_range,
            'storage' => $request->storage,
            'sort' => $request->get('sort', 'newest'),
            'payment_method' => $paymentMethod,
            'result_count' => $phones->total(),
            'price_stats' => $this->getPriceStatistics($phones),
        ];
        
        // Add search suggestions if results are low
        if ($phones->isEmpty() && $request->search) {
            $filters['suggestions'] = $this->getSearchSuggestions($request->search);
        }
        
        return view('pages.pricing', compact('phones', 'filters'));
    }
    
    private function applySearchFilter($query, Request $request): void
    {
        if (!$request->filled('search')) {
            return;
        }
        
        $search = trim($request->search);
        
        // Use full-text search if available
        if (method_exists(Phone::class, 'scopeSearch')) {
            $query->search($search);
            return;
        }
        
        // Optimized LIKE search with multiple patterns
        $searchTerms = array_filter(explode(' ', $search));
        
        if (count($searchTerms) === 1) {
            $query->where('name', 'like', "%{$search}%");
        } else {
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    if (strlen($term) >= 2) { // Avoid too short terms
                        $q->orWhere('name', 'like', "%{$term}%");
                    }
                }
            });
        }
    }
    
    private function applyBrandFilter($query, Request $request): void
    {
        if (!$request->filled('brand') || !isset(self::BRAND_FILTERS[$request->brand])) {
            return;
        }
        
        $brand = $request->brand;
        $keywords = self::BRAND_FILTERS[$brand];
        
        $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $keyword) {
                $q->orWhere('name', 'like', "%{$keyword}%");
            }
        });
    }
    
    private function applyPriceFilter($query, Request $request): void
    {
        if (!$request->filled('price_range') || !isset(self::PRICE_RANGES[$request->price_range])) {
            return;
        }
        
        $range = self::PRICE_RANGES[$request->price_range];
        
        if ($range[1] === null) {
            $query->where('price', '>=', $range[0]);
        } else {
            $query->whereBetween('price', $range);
        }
    }
    
    private function applyStorageFilter($query, Request $request): void
    {
        if (!$request->filled('storage') || !is_numeric($request->storage)) {
            return;
        }
        
        $storage = $request->storage;
        
        // More flexible storage search
        $query->where(function ($q) use ($storage) {
            $q->where('name', 'like', "%{$storage}GB%")
              ->orWhere('name', 'like', "% {$storage} %")
              ->orWhere('name', 'like', "%{$storage} %");
        });
    }
    
    private function applySorting($query, Request $request): void
    {
        $sort = $request->get('sort', 'newest');
        
        if (isset(self::SORT_OPTIONS[$sort])) {
            $sortOption = self::SORT_OPTIONS[$sort];
            $query->orderBy($sortOption['field'], $sortOption['direction']);
        } else {
            $query->latest();
        }
    }
    
    private function calculateLipaPrices($phones): void
    {
        foreach ($phones as $phone) {
            if ($phone->price > 0) {
                $phone->lipa_upfront = ceil($phone->price * 0.4);
                $remaining = $phone->price - $phone->lipa_upfront;
                $totalWithInterest = ceil($remaining * 1.5);
                $phone->lipa_weekly = ceil($totalWithInterest / 12);
            }
        }
    }
    
    private function getPriceStatistics($phones): array
    {
        if ($phones->isEmpty()) {
            return ['min' => 0, 'max' => 0, 'avg' => 0];
        }
        
        $prices = $phones->pluck('price')->filter()->values();
        
        if ($prices->isEmpty()) {
            return ['min' => 0, 'max' => 0, 'avg' => 0];
        }
        
        return [
            'min' => $prices->min(),
            'max' => $prices->max(),
            'avg' => (int) $prices->avg(),
        ];
    }
    
    private function getSearchSuggestions(string $searchTerm): array
    {
        $suggestions = [];
        
        // Common misspellings or alternative search terms
        $searchTerm = strtolower($searchTerm);
        
        if (str_contains($searchTerm, 'iphone') || str_contains($searchTerm, 'i phone')) {
            $suggestions[] = 'Try searching for specific models like: iPhone 13, iPhone 14 Pro';
        }
        
        if (str_contains($searchTerm, 'samsung') || str_contains($searchTerm, 'galaxy')) {
            $suggestions[] = 'Try searching for specific models like: Galaxy S23, Galaxy Fold';
        }
        
        if (str_contains($searchTerm, 'gb') || str_contains($searchTerm, 'storage')) {
            $suggestions[] = 'Try searching by storage: 128GB, 256GB, 512GB';
        }
        
        return array_unique($suggestions);
    }
    
    private function getPerPage(Request $request): int
    {
        $perPage = $request->get('per_page', 12);
        
        // Validate per_page is a reasonable number
        $allowedPerPage = [12, 24, 48, 96];
        
        return in_array($perPage, $allowedPerPage) ? $perPage : 12;
    }
    
    private function generateCacheKey(Request $request, string $paymentMethod): string
    {
        $keyParts = [
            'phones',
            $paymentMethod,
            $request->get('search', ''),
            $request->get('brand', ''),
            $request->get('price_range', ''),
            $request->get('storage', ''),
            $request->get('sort', 'newest'),
            $request->get('page', 1),
        ];
        
        return 'pricing_' . md5(implode('|', $keyParts));
    }
    
    // API endpoint for AJAX filtering
    public function apiPricing(Request $request)
    {
        // Return JSON response for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            $query = Phone::query();
            
            $this->applySearchFilter($query, $request);
            $this->applyBrandFilter($query, $request);
            $this->applyPriceFilter($query, $request);
            $this->applyStorageFilter($query, $request);
            $this->applySorting($query, $request);
            
            $phones = $query->select(['id', 'name', 'price', 'image_path'])
                           ->paginate(12);
            
            return response()->json([
                'success' => true,
                'data' => $phones->items(),
                'meta' => [
                    'current_page' => $phones->currentPage(),
                    'last_page' => $phones->lastPage(),
                    'total' => $phones->total(),
                ],
                'filters' => $request->only(['search', 'brand', 'price_range', 'storage', 'sort']),
            ]);
        }
        
        return redirect()->route('pricing');
    }
    
    // Get filter options for dropdowns (could be cached)
    public function getFilterOptions()
    {
        // Cache these queries since they don't change often
        $cacheKey = 'phone_filter_options';
        $ttl = now()->addHours(6); // Cache for 6 hours
        
        return cache()->remember($cacheKey, $ttl, function () {
            return [
                'price_ranges' => [
                    ['value' => '0-50000', 'label' => 'Under 50K', 'count' => Phone::whereBetween('price', [1, 50000])->count()],
                    ['value' => '50000-80000', 'label' => '50K - 80K', 'count' => Phone::whereBetween('price', [50000, 80000])->count()],
                    ['value' => '80000+', 'label' => '80K+', 'count' => Phone::where('price', '>=', 80000)->count()],
                ],
                'storage_options' => [
                    ['value' => '128', 'label' => '128GB', 'count' => Phone::where('name', 'like', '%128GB%')->count()],
                    ['value' => '256', 'label' => '256GB', 'count' => Phone::where('name', 'like', '%256GB%')->count()],
                    ['value' => '512', 'label' => '512GB', 'count' => Phone::where('name', 'like', '%512GB%')->count()],
                ],
                'brand_counts' => [
                    'Apple' => Phone::where('name', 'like', '%iPhone%')->count(),
                    'Samsung' => Phone::where('name', 'like', '%Samsung%')->orWhere('name', 'like', '%Galaxy%')->count(),
                ],
            ];
        });
    }
}