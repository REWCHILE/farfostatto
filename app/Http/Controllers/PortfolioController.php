<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;

class PortfolioController extends Controller
{
    public function index()
    {
        $categories = ['Todos', 'Cover Up', 'Anime', 'Realismo', 'Black & Grey', 'Acuarela'];
        $portfolioItems = PortfolioItem::with('style')->get();

        return view('pages.portfolio', compact('categories', 'portfolioItems'));
    }
}
