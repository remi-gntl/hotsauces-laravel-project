<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SauceController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('sauces.index');
    }
    return redirect()->route('login.form');
})->name('home');

// Routes d'authentification
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Routes protégées pour les sauces
Route::middleware('auth')->group(function () {
    Route::resource('sauces', SauceController::class);
    Route::post('/sauces/{sauce}/like', [SauceController::class, 'like'])->name('sauces.like');
    Route::post('/sauces/{sauce}/dislike', [SauceController::class, 'dislike'])->name('sauces.dislike');
});