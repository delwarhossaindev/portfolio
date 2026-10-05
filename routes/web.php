<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeContentController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects/{project:slug}', [PortfolioController::class, 'showProject'])->name('projects.show');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::post('/contact', [ContactFormController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

// Blog - disabled for now, uncomment to enable.
// Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
// Route::get('/blog/{article:slug}', [BlogController::class, 'show'])->name('blog.show');

/*
|--------------------------------------------------------------------------
| Admin authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    /*
    | Content management - admins and editors.
    */
    Route::middleware('role:admin|editor')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/home', [HomeContentController::class, 'edit'])->name('home.edit');
        Route::put('/home', [HomeContentController::class, 'update'])->name('home.update');

        Route::resource('experiences', ExperienceController::class)->except(['show']);
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('articles', AdminArticleController::class)->except(['show']);

        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::post('/contacts/mark-all-read', [ContactController::class, 'markAllRead'])->name('contacts.markAllRead');
        Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    });

    /*
    | Access control - admins only.
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);
    });

    /*
    | Developer tools - admins only, and only registered on a local debug install.
    | On a server, run these through `php artisan` instead.
    */
    if (app()->environment('local') && config('app.debug')) {
        Route::middleware('role:admin')->group(function () {
            Route::get('/terminal-panel', [TerminalController::class, 'show'])->name('terminal.panel');
            Route::post('/terminal-panel/run', [TerminalController::class, 'run'])
                ->middleware('throttle:10,1')
                ->name('terminal.run');

            Route::post('/storage-link', function () {
                Artisan::call('storage:link');

                return back()->with('admin_success', trim(Artisan::output()) ?: 'Storage link created.');
            })->name('dev.storage-link');

            Route::post('/migrate', function () {
                Artisan::call('migrate', ['--force' => true]);

                return back()->with('admin_success', trim(Artisan::output()) ?: 'Migrations ran.');
            })->name('dev.migrate');
        });
    }
});
