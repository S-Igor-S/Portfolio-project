<?php

namespace App\Http\Controllers;

use App\Models\HomeSlide;

class HomeController extends Controller
{
    public function index()
    {
        $homeSlide = HomeSlide::find(1);
        return view('frontend.index', compact('homeSlide'));
    }
}
