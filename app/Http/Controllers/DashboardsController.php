<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;

class DashboardsController extends Controller
{
public function index()
{
    // Pick 6 random phones for each tab
    $fullPhones = Phone::inRandomOrder()->take(6)->get();
    $lipaPhones = Phone::where('name', 'like', '%iPhone%')->inRandomOrder()->take(6)->get();

    return view('pages.landing', compact('fullPhones', 'lipaPhones'));
}

    public function index2()
    {
        return view('pages.index2');
    }

    public function index3()
    {
        return view('pages.index3');
    }

    public function index4()
    {
        return view('pages.index4');
    }

    public function index5()
    {
        return view('pages.index5');
    }

    public function index6()
    {
        return view('pages.index6');
    }

    public function index7()
    {
        return view('pages.index7');
    }

    public function index8()
    {
        return view('pages.index8');
    }

    public function index9()
    {
        return view('pages.index9');
    }

    public function index10()
    {
        return view('pages.index10');
    }

    public function index11()
    {
        return view('pages.index11');
    }

    public function index12()
    {
        return view('pages.index12');
    }

}
