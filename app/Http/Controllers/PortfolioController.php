<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\FooterController;
use App\Models\ContentElement;
use App\Models\Footer;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PortfolioController extends Controller
{

    public function index()
    {
        $route     = Route::current()->getName();

        $footer = ContentElement::where('name', FooterController::TEMPLATE_NAME)->first();
        $footer->content = json_decode($footer->content);

        $portfolio = Portfolio::latest()->get();

        return view('frontend.portfolio',
            compact('portfolio', 'footer', 'route'));
    }

    public function portfolioDetails($id)
    {
        $route     = Route::current()->getName();

        $footer = ContentElement::where('name', FooterController::TEMPLATE_NAME)->first();
        $footer->content = json_decode($footer->content);

        $portfolio = Portfolio::findOrFail($id);

        return view('frontend.portfolio_details',
            compact('portfolio', 'footer', 'route'));
    }

}
