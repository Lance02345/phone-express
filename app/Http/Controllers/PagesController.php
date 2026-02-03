<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;

class PagesController extends Controller
{

public function pricing(Request $request)
{
    // Base query for all phones
    $query = Phone::query();
    
    // Apply search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%");
    }
    
    // Apply brand filter
    if ($request->filled('brand')) {
        $brand = $request->brand;
        if ($brand === 'Apple') {
            $query->where('name', 'like', '%iPhone%');
        } elseif ($brand === 'Samsung') {
            $query->where('name', 'like', '%Samsung%');
        }
    }
    
    // Apply price filter
    if ($request->filled('price_range')) {
        $range = $request->price_range;
        if ($range === '0-50000') {
            $query->whereBetween('price', [1, 50000]);
        } elseif ($range === '50000-80000') {
            $query->whereBetween('price', [50000, 80000]);
        } elseif ($range === '80000+') {
            $query->where('price', '>=', 80000);
        }
    }
    
    // Apply storage filter
    if ($request->filled('storage')) {
        $storage = $request->storage;
        $query->where('name', 'like', "%{$storage}GB%");
    }
    
    // Apply sorting
    $sort = $request->get('sort', 'newest');
    switch ($sort) {
        case 'price_asc':
            $query->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('price', 'desc');
            break;
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('name', 'desc');
            break;
        default:
            $query->latest();
    }
    
    // Check payment method tab
    $paymentMethod = $request->get('payment_method', 'full');
    
    if ($paymentMethod === 'lipa') {
        // Only show iPhones for Lipa Mdogo Mdogo
        $query->where('name', 'like', '%iPhone%');
    }
    
    // Paginate results
    $phones = $query->paginate(12)->appends($request->except('page'));
    
    // Pass filters to view
    $filters = [
        'search' => $request->search,
        'brand' => $request->brand,
        'price_range' => $request->price_range,
        'storage' => $request->storage,
        'sort' => $sort,
        'payment_method' => $paymentMethod
    ];
    
    return view('pages.pricing', compact('phones', 'filters'));
}



}
