<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Sliders\BlogCategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\FooterController as AdminFooterController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
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

Route::controller(BannerController::class)->group(function () {
    Route::get('dashboard/banner', 'edit')->name('dashboard.banner');
    Route::post('dashboard/banner/update', 'update')->name('dashboard.banner.update');
});

Route::controller(AdminAboutController::class)->group(function () {
    Route::get('dashboard/about', 'edit')->name('dashboard.about');
    Route::post('dashboard/about/update', 'update')
         ->name('dashboard.about.update');
    Route::get('dashboard/about/images/add', 'addImage')
         ->name('dashboard.about.images.add');
    Route::post('dashboard/about/images/insert', 'insertImage')
         ->name('dashboard.about.images.insert');

    Route::get('dashboard/about/images/all', 'getImagesList')
         ->name('dashboard.about.images.all');
    Route::get('dashboard/about/edit/image/{id}', 'editImage')
         ->name('dashboard.about.edit.image');
    Route::get('dashboard/about/about/delete/image/{id}', 'deleteImage')
         ->name('dashboard.about.delete.image');
});

Route::controller(AdminPortfolioController::class)->group(function () {
    Route::get('dashboard/portfolio/all', 'getAllPortfolio')->name('dashboard.portfolio.all');
    Route::get('dashboard/portfolio/add', 'addPortfolio')->name('dashboard.portfolio.add');
    Route::post('dashboard/portfolio/save', 'savePortfolio')->name('dashboard.portfolio.save');
    Route::get('dashboard/portfolio/edit/{id}', 'editPortfolio')->name('dashboard.portfolio.edit');
    Route::post('dashboard/portfolio/update', 'updatePortfolio')
         ->name('dashboard.portfolio.update');
    Route::get('dashboard/portfolio/delete/{id}', 'deletePortfolio')
         ->name('dashboard.portfolio.delete');
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

Route::controller(AdminBlogController::class)->group(function () {
    Route::get('dashboard/blog/all', 'getAllBlog')->name('dashboard.blog.all');
    Route::get('dashboard/blog/add', 'addBlog')->name('dashboard.blog.add');
    Route::post('dashboard/blog/save', 'saveBlog')->name('dashboard.blog.save');
    Route::get('dashboard/blog/edit/{id}', 'editBlog')->name('dashboard.blog.edit');
    Route::post('dashboard/blog/update', 'updateBlog')->name('dashboard.blog.update');
    Route::get('dashboard/blog/delete/{id}', 'deleteBlog')->name('dashboard.blog.delete');
});

Route::controller(BlogController::class)->group(function () {
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog/details/{id}', 'index')->name('blog.details');
    Route::get('/blog/category/{id}', 'сategory')->name('blog.category');
});

Route::controller(AdminFooterController::class)->group(function () {
    Route::get('dashboard/footer/setup', 'footerSetup')->name('dashboard.footer.setup');
    Route::post('dashboard/footer/update', 'updateFooter')->name('dashboard.footer.update');
});

Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'index')->name('contact');
    Route::post('/contact/save/message', 'saveMessage')->name('contact.save.message');
});

Route::controller(AdminContactController::class)->group(function () {
    Route::get('dashboard/contact/message', 'index')->name('dashboard.contact.message');
    Route::get('dashboard/contact/delete/message/{id}', 'deleteMessage')->name('dashboard.contact.delete.message');
});

require __DIR__.'/auth.php';
