<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get('/', [PortfolioController::class, 'index']);
Route::post('/contact', [PortfolioController::class, 'contact'])->name('contact.store');
