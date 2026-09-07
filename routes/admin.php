<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('throttle:login')
            ->name('login.store');
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware('auth')->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('requests', [ServiceRequestController::class, 'index'])->name('requests.index');
        Route::get('requests/{serviceRequest}', [ServiceRequestController::class, 'show'])->name('requests.show');
        Route::patch('requests/{serviceRequest}', [ServiceRequestController::class, 'update'])->name('requests.update');

        Route::resource('categories', ServiceCategoryController::class)
            ->parameters(['categories' => 'serviceCategory'])
            ->except(['show']);

        Route::resource('services', ServiceController::class)->except(['show']);

        Route::resource('faqs', FaqController::class)->except(['show']);

        Route::get('company', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('company', [CompanyController::class, 'update'])->name('company.update');

        Route::get('pages', [PageContentController::class, 'index'])->name('pages.index');
        Route::get('pages/{group}', [PageContentController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{group}', [PageContentController::class, 'update'])->name('pages.update');

        Route::get('account', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('account', [AccountController::class, 'update'])->name('account.update');
    });
});
