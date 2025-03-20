<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route pour obtenir l'utilisateur connecté
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes pour les sauces
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('sauces', ApiController::class)->except(['create', 'edit']);
    Route::post('/sauces/{id}/like', [ApiController::class, 'like'])->name('sauces.like');
});