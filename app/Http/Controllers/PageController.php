<?php

namespace App\Http\Controllers;

use App\Price;

class PageController extends Controller
{
    /**
     * Show the main page.
     */
    public function index()
    {
        return view('index')
            ->withPricing(Price::getLastWeek());
    }
}
