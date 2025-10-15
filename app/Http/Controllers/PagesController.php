<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;

class PagesController extends Controller
{
    public function aboutus()
    {
        return view('pages.aboutus');
    }

    public function blog()
    {
        return view('pages.blog');
    }

    public function blog_details()
    {
        return view('pages.blog-details');
    }

    public function blog_create()
    {
        return view('pages.blog-create');
    }

    public function chat()
    {
        return view('pages.chat');
    }

    public function contacts()
    {
        return view('pages.contacts');
    }

    public function contactus()
    {
        return view('pages.contactus');
    }

    public function add_products()
    {
        return view('pages.add-products');
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function checkout()
    {
        return view('pages.checkout');
    }

    public function edit_products()
    {
        return view('pages.edit-products');
    }

    public function order_details()
    {
        return view('pages.order-details');
    }

    public function orders()
    {
        return view('pages.orders');
    }

    public function products()
    {
        return view('pages.products');
    }

    public function products_details()
    {
        return view('pages.products-details');
    }

    public function products_list()
    {
        return view('pages.products-list');
    }

    public function wishlist()
    {
        return view('pages.wishlist');
    }

    public function mail()
    {
        return view('pages.mail');
    }

    public function mail_settings()
    {
        return view('pages.mail-settings');
    }

    public function empty_page()
    {
        return view('pages.empty-page');
    }

    public function faqs()
    {
        return view('pages.faqs');
    }

    public function filemanager()
    {
        return view('pages.filemanager');
    }

    public function invoice_create()
    {
        return view('pages.invoice-create');
    }

    public function invoice_details()
    {
        return view('pages.invoice-details');
    }

    public function invoice_list()
    {
        return view('pages.invoice-list');
    }

    public function landing()
    {
        return view('pages.landing');
    }

    public function landing_jobs()
    {
        return view('pages.landing-jobs');
    }

    public function notifications()
    {
        return view('pages.notifications');
    }

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

    public function profile()
    {
        return view('pages.profile');
    }

    public function reviews()
    {
        return view('pages.reviews');
    }

    public function teams()
    {
        return view('pages.teams');
    }

    public function terms_conditions()
    {
        return view('pages.terms-conditions');
    }

    public function timeline()
    {
        return view('pages.timeline');
    }

    public function todo_list()
    {
        return view('pages.todo-list');
    }

}
