<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Support\Localization;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(Localization::default().'.home', status: 301);
});

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

foreach (Localization::supported() as $locale) {
    $path = fn (string $key): string => Localization::path($key, $locale);

    Route::prefix($locale)
        ->name($locale.'.')
        ->group(function () use ($path) {
            Route::get('/', [HomeController::class, 'index'])->name('home');

            Route::get($path('services'), [ServiceController::class, 'index'])->name('services.index');
            Route::get($path('services').'/{serviceCategory}', [ServiceController::class, 'category'])->name('services.category');
            Route::get($path('services').'/{serviceCategory}/{service}', [ServiceController::class, 'show'])->name('services.show');

            Route::get($path('about'), [PageController::class, 'about'])->name('about');
            Route::get($path('business'), [PageController::class, 'business'])->name('business');
            Route::get($path('faq'), [PageController::class, 'faq'])->name('faq');

            Route::get($path('contact'), [ContactController::class, 'create'])->name('contact.create');
            Route::post($path('contact'), [ContactController::class, 'store'])
                ->middleware('throttle:contact')
                ->name('contact.store');

            Route::get($path('imprint'), [PageController::class, 'imprint'])->name('legal.imprint');
            Route::get($path('privacy'), [PageController::class, 'privacy'])->name('legal.privacy');
            Route::get($path('terms'), [PageController::class, 'terms'])->name('legal.terms');
            Route::get($path('withdrawal'), [PageController::class, 'withdrawal'])->name('legal.withdrawal');
        });
}

require __DIR__.'/admin.php';
