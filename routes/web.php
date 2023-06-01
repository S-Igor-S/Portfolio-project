<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Sliders\AboutSlideController;
use App\Http\Controllers\Sliders\HomeSlideController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sliders\PortfolioSlideController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::controller(AboutController::class)->group(function () {
    Route::get('/about', 'index')->name('about');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'index')->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/dashboard/profile', 'profile')->name('dashboard.profile');
    Route::get('/dashboard/edit/profile', 'editProfile')->name('dashboard.edit.profile');
    Route::post('/dashboard/store/profile', 'storeProfile')->name('dashboard.store.profile');
    Route::get('/logout', 'destroy')->name('dashboard.logout');
    Route::get('/change/password', 'ChangePassword')->name('dashboard.change.password');
    Route::post('/update/password', 'UpdatePassword')->name('dashboard.update.password');
});

Route::controller(HomeSlideController::class)->group(function () {
    Route::get('/home/slide', 'getHomeSlide')->name('home.slide');
    Route::post('/update/slider', 'updateHomeSlide')->name('update.slider');
});

Route::controller(AboutSlideController::class)->group(function () {
    Route::get('/about/slide', 'getAboutSlide')->name('about.slide');
    Route::post('/about/update/slide', 'updateAbout')->name('about.update.slide');
    Route::get('/about/multiimage', 'getAboutSlideMultiImage')->name('about.multiimage');
    Route::get('about/multiimage/all', 'getAllMultiImage')->name('about.multiimage.all');
    Route::post('/about/insert/multiimage', 'insertMultiImage')->name('about.insert.multiimage');
    Route::get('/about/edit/multiimage/{id}', 'editMultiImage')->name('about.edit.multiimage');
    Route::post('/about/update/multiimage', 'updateMultiImage')->name('about.update.multiimage');
    Route::get('/about/delete/multiimage/{id}', 'deleteMultiImage')->name('about.delete.multiimage');
});

Route::controller(PortfolioSlideController::class)->group(function () {
    Route::get('/portfolio/all', 'getAllPortfolio')->name('portfolio.all');
    Route::get('/portfolio/add', 'addPortfolio')->name('portfolio.add');
    Route::post('/portfolio/save', 'savePortfolio')->name('portfolio.save');
    Route::get('/portfolio/edit/{id}', 'editPortfolio')->name('portfolio.edit');
    Route::post('/portfolio/update', 'updatePortfolio')->name('portfolio.update');
    Route::get('/portfolio/delete/{id}', 'deletePortfolio')->name('portfolio.delete');
    Route::get('/portfolio/details/{id}', 'portfolioDetails')->name('portfolio.details');
});

require __DIR__.'/auth.php';
