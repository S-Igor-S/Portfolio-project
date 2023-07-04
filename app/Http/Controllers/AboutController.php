<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\FooterController;
use App\Models\About;
use App\Models\ContentElement;
use App\Models\Footer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use \App\Http\Controllers\Admin\AboutController as AdminAboutController;
use Illuminate\Contracts\Foundation\Application as ContractsFoundation;
use Illuminate\Support\Facades\Route;

class AboutController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|ContractsFoundation
    {
        $route = Route::current()->getName();

        $footer = ContentElement::where('name', FooterController::TEMPLATE_NAME)->first();
        $footer->content = json_decode($footer->content);

        $aboutPage = ContentElement::where('name', AdminAboutController::TEMPLATE_NAME)->first();
        $aboutPage->content = json_decode($aboutPage->content);
        return view('frontend.about',compact('aboutPage', 'footer', 'route'));

    }
}
