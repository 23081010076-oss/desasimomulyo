<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotlineController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/beranda', [PublicSiteController::class, 'index'])->name('home');
Route::get('/profil-desa', [PublicSiteController::class, 'profile'])->name('profile');
Route::get('/peta-desa', [PublicSiteController::class, 'map'])->name('map');
Route::get('/berita', [PublicSiteController::class, 'news'])->name('news');
Route::get('/berita/{article:slug}', [PublicSiteController::class, 'showNews'])->name('news.show');
Route::get('/produk', [PublicSiteController::class, 'products'])->name('products');

Route::get('/hotline', [HotlineController::class, 'index'])->name('hotline');
Route::post('/hotline', [HotlineController::class, 'store'])
    ->name('hotline.store')
    ->middleware(['honeypot', 'throttle:hotline']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store')
        ->middleware('throttle:login');

    // ─── Register dinonaktifkan untuk publik ─────────────────────────────
    // Admin dibuat via: php artisan tinker → User::create([...])
    // Mengekspos halaman register membuka vektor serangan yang tidak perlu.
    Route::get('/register', fn() => abort(404))->name('register');
    Route::post('/register', fn() => abort(404))->name('register.store');
});

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->name('logout');

require __DIR__.'/admin.php';

