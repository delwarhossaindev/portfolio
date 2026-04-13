<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PortfolioController;

Route::get('/', [PortfolioController::class, 'index']);
Route::post('/contact', [PortfolioController::class, 'contact'])->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/terminal-panel', [PortfolioController::class, 'terminalPanel'])->name('terminal.panel');
    Route::post('/terminal-panel/run', [PortfolioController::class, 'runTerminalCommand'])->name('terminal.run');
    Route::get('/admin/dashboard', [PortfolioController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/admin/dashboard', [PortfolioController::class, 'updateAdminDashboard'])->name('admin.dashboard.update');
});
