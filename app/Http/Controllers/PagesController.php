<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;

class PagesController extends Controller
{
    private const PRICE_RANGES = [
        '0-50000' => ['min' => 1, 'max' => 50000],
        '50000-80000' => ['min' => 50000, 'max' => 80000],
        '80000+' => ['min' => 80000, 'max' => null],
    ];

    private const BRAND_FILTERS = [
        'Apple' => ['iPhone'],
        'Samsung' => ['Samsung', 'Galaxy'],
    ];

    private const SORT_OPTIONS = [
        'random' => ['field' => 'RAND()', 'direction' => '', 'raw' => true],
        'newest' => ['field' => 'created_at', 'direction' => 'desc'],
        'price_asc' => ['field' => 'price', 'direction' => 'asc'],
        'price_desc' => ['field' => 'price', 'direction' => 'desc'],
        'name_asc' => ['field' => 'name', 'direction' => 'asc'],
        'name_desc' => ['field' => 'name', 'direction' => 'desc'],
    ];

    public function pricing(Request $request)
    {
        $query = Phone::query();
        
        // Default to random sorting if no sort specified
        $sort = $request->get('sort', 'random');
        
        // Apply filters
        $this->applySearchFilter($query, $request);
        $this->applyBrandFilter($query, $request);
        $this->applyPriceFilter($query, $request);
        $this->applyStorageFilter($query, $request);
        
        // Payment method filter
        $paymentMethod = $request->get('payment_method', 'full');
        if ($paymentMethod === 'lipa') {
            $query->where('name', 'like', '%iPhone%');
        }
        
        // Apply sorting
        $this->applySorting($query, $sort);
        
        // Get paginated results
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
            'sort' => $sort,
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
    
    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['success' => false, 'suggestions' => []]);
        }
        
        $suggestions = Phone::where('name', 'like', "%{$query}%")
            ->take(5)
            ->pluck('name')
            ->toArray();
        
        return response()->json([
            'success' => true,
            'suggestions' => $suggestions
        ]);
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
        
        // FIXED: Better search for "iphone 13" - search for exact combination
        $search = strtolower($search);
        
        // Check if it's an iPhone search with model number
        if (preg_match('/iphone\s+(\d+)/i', $search, $matches)) {
            $model = $matches[1];
            $query->where(function ($q) use ($search, $model) {
                // Search for exact iPhone model
                $q->where('name', 'like', "%iPhone {$model}%")
                  ->orWhere('name', 'like', "%iPhone{$model}%");
            });
        } else {
            // Regular search with word boundaries
            $searchTerms = array_filter(explode(' ', $search));
            
            if (count($searchTerms) === 1) {
                $query->where('name', 'like', "%{$search}%");
            } else {
                $query->where(function ($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        if (strlen($term) >= 2) {
                            // Add word boundary search for better matching
                            $q->where('name', 'like', "%{$term}%");
                        }
                    }
                });
            }
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
        
        // FIXED: Handle price ranges correctly
        if ($range['max'] === null) {
            $query->where('price', '>=', $range['min']);
        } else {
            $query->whereBetween('price', [$range['min'], $range['max']]);
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
              ->orWhere('name', 'like', "% {$storage}GB%")
              ->orWhere('name', 'regexp', "[[:<:]]{$storage}GB[[:>:]]");
        });
    }
    
    private function applySorting($query, string $sort): void
    {
        if (isset(self::SORT_OPTIONS[$sort])) {
            $sortOption = self::SORT_OPTIONS[$sort];
            
            if (isset($sortOption['raw']) && $sortOption['raw']) {
                // For random sorting
                $query->orderByRaw($sortOption['field']);
            } else {
                $query->orderBy($sortOption['field'], $sortOption['direction']);
            }
        } else {
            // Default to random if invalid sort option
            $query->orderByRaw('RAND()');
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
            return null;
        }
        
        $prices = $phones->pluck('price')->filter(function($price) {
            return $price > 0;
        })->values();
        
        if ($prices->isEmpty()) {
            return null;
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
            $this->applySorting($query, $request->get('sort', 'random'));
            
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
}