<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Foundation\Application as ContractsFoundation;

class AboutController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|ContractsFoundation
    {
        $aboutPage = About::find(1);
        return view('frontend.about',compact('aboutPage'));

    }
}
