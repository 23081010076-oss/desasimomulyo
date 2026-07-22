<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentTypeAdminController;
use App\Http\Controllers\Admin\DocumentRequestAdminController;
use App\Http\Controllers\Admin\ArticleAdminController;
use App\Http\Controllers\Admin\BudgetTransactionAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\ReportAdminController;
use App\Http\Controllers\Admin\ProfileGalleryImageAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('reports', ReportAdminController::class)->except(['show']);
        Route::resource('document-types', DocumentTypeAdminController::class)->except(['show']);
        Route::resource('document-requests', DocumentRequestAdminController::class)->except(['show']);
        Route::resource('articles', ArticleAdminController::class)->except(['show']);
        Route::resource('budgets', BudgetTransactionAdminController::class)->except(['show']);
        Route::resource('products', ProductAdminController::class)->except(['show']);
        Route::resource('profile-gallery-images', ProfileGalleryImageAdminController::class)->except(['show']);
        
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingAdminController::class, 'index'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingAdminController::class, 'update'])->name('settings.update');
    });
