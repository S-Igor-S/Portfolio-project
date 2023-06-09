<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Sliders\AboutSlideController;
use App\Http\Controllers\Sliders\BlogAdminController;
use App\Http\Controllers\Sliders\BlogCategoryController;
use App\Http\Controllers\Sliders\ContactAdminController;
use App\Http\Controllers\Sliders\FooterAdminController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'index')
         ->middleware(['auth', 'verified'])
         ->name('dashboard');
    Route::get('/dashboard/profile', 'profile')->name('dashboard.profile');
    Route::get('/dashboard/edit/profile', 'editProfile')
         ->name('dashboard.edit.profile');
    Route::post('/dashboard/store/profile', 'storeProfile')
         ->name('dashboard.store.profile');
    Route::get('/logout', 'destroy')->name('dashboard.logout');
    Route::get('/change/password', 'ChangePassword')
         ->name('dashboard.change.password');
    Route::post('/update/password', 'UpdatePassword')
         ->name('dashboard.update.password');
});

Route::controller(HomeSlideController::class)->group(function () {
    Route::get('/home/slide', 'getHomeSlide')->name('home.slide');
    Route::post('/update/slider', 'updateHomeSlide')->name('update.slider');
});

Route::controller(AboutSlideController::class)->group(function () {
    Route::get('/about/slide', 'getAboutSlide')->name('about.slide');
    Route::post('/about/update/slide', 'updateAbout')
         ->name('about.update.slide');
    Route::get('/about/multiimage', 'getAboutSlideMultiImage')
         ->name('about.multiimage');
    Route::get('about/multiimage/all', 'getAllMultiImage')
         ->name('about.multiimage.all');
    Route::post('/about/insert/multiimage', 'insertMultiImage')
         ->name('about.insert.multiimage');
    Route::get('/about/edit/multiimage/{id}', 'editMultiImage')
         ->name('about.edit.multiimage');
    Route::post('/about/update/multiimage', 'updateMultiImage')
         ->name('about.update.multiimage');
    Route::get('/about/delete/multiimage/{id}', 'deleteMultiImage')
         ->name('about.delete.multiimage');
});

Route::controller(PortfolioSlideController::class)->group(function () {
    Route::get('/portfolio/all', 'getAllPortfolio')->name('portfolio.all');
    Route::get('/portfolio/add', 'addPortfolio')->name('portfolio.add');
    Route::post('/portfolio/save', 'savePortfolio')->name('portfolio.save');
    Route::get('/portfolio/edit/{id}', 'editPortfolio')->name('portfolio.edit');
    Route::post('/portfolio/update', 'updatePortfolio')
         ->name('portfolio.update');
    Route::get('/portfolio/delete/{id}', 'deletePortfolio')
         ->name('portfolio.delete');
});

Route::controller(PortfolioController::class)->group(function () {
    Route::get('/portfolio', 'index')->name('portfolio');
    Route::get('/portfolio/details/{id}', 'portfolioDetails')
         ->name('portfolio.details');
});

Route::controller(BlogCategoryController::class)->group(function () {
    Route::get('blog/category/all', 'getAllBlogCategories')
         ->name('blog.category.all');
    Route::get('/blog/category/add', 'addBlogCategory')
         ->name('blog.category.add');
    Route::post('/blog/category/save', 'saveBlogCategory')
         ->name('blog.category.save');
    Route::get('/blog/category/edit/{id}', 'editBlogCategory')
         ->name('blog.category.edit');
    Route::post('/blog/category/update/{id}', 'updateBlogCategory')
         ->name('blog.category.update');
    Route::get('/blog/category/delete/{id}', 'deleteBlogCategory')
         ->name('blog.category.delete');
});

Route::controller(BlogAdminController::class)->group(function () {
    Route::get('/blog/all', 'getAllBlog')->name('blog.all');
    Route::get('/blog/add', 'addBlog')->name('blog.add');
    Route::post('/blog/save', 'saveBlog')->name('blog.save');
    Route::get('/blog/edit/{id}', 'editBlog')->name('blog.edit');
    Route::post('/blog/update', 'updateBlog')->name('blog.update');
    Route::get('/blog/delete/{id}', 'deleteBlog')->name('blog.delete');
});

Route::controller(BlogController::class)->group(function () {
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog/details/{id}', 'index')->name('blog.details');
    Route::get('/blog/category/{id}', 'сategory')->name('blog.category');
});

Route::controller(FooterAdminController::class)->group(function () {
    Route::get('/footer/setup', 'footerSetup')->name('footer.setup');
    Route::post('/footer/update', 'updateFooter')->name('footer.update');
});

Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'index')->name('contact');
    Route::post('/contact/save/message', 'saveMessage')->name('contact.save.message');
    Route::get('/contact/message', 'ContactMessage')->name('contact.message');
    Route::get('/contact/delete/message/{id}', 'DeleteMessage')->name('contact.delete.message');
});

Route::controller(ContactAdminController::class)->group(function () {
    Route::get('/contact/message', 'index')->name('contact.message');
    Route::get('/contact/delete/message/{id}', 'deleteMessage')->name('contact.delete.message');
});

require __DIR__.'/auth.php';
