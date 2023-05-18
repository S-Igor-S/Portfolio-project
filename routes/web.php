<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('frontend.index');
})->name('home');

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

require __DIR__.'/auth.php';
