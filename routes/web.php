<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', [PortfolioController::class, 'index']);
Route::post('/contact', [PortfolioController::class, 'contact'])->name('contact.store');

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created: ' . Artisan::output();
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/terminal-panel', [PortfolioController::class, 'terminalPanel'])->name('terminal.panel');
    Route::post('/terminal-panel/run', [PortfolioController::class, 'runTerminalCommand'])->name('terminal.run');
    Route::get('/admin/dashboard', [PortfolioController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/home', [PortfolioController::class, 'homeEdit'])->name('admin.home.edit');
    Route::put('/admin/home', [PortfolioController::class, 'homeUpdate'])->name('admin.home.update');

    Route::resource('admin/experiences', ExperienceController::class)
        ->except(['show'])
        ->names('admin.experiences');

    Route::resource('admin/projects', ProjectController::class)
        ->except(['show'])
        ->names('admin.projects');

    Route::get('/admin/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/admin/contacts/{contact}', [ContactController::class, 'show'])->name('admin.contacts.show');
    Route::delete('/admin/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');

    Route::resource('admin/users', UserController::class)
        ->except(['show'])
        ->names('admin.users');

    Route::resource('admin/roles', RoleController::class)
        ->except(['show'])
        ->names('admin.roles');

    Route::resource('admin/permissions', PermissionController::class)
        ->except(['show'])
        ->names('admin.permissions');
});
