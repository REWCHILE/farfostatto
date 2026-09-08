<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;

class HomeController extends Controller
{
    public function index()
    {
        $featuredItems = PortfolioItem::with('style')
            ->where('is_featured', true)
            ->take(6)
            ->get();

        return view('pages.home', compact('featuredItems'));
    }
}
