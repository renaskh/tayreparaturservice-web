<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Queries\Catalog;
use App\Support\Localization;
use App\Support\PublicDirectory;
use App\View\Composers\NavigationComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route as Router;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->usePublicPath(PublicDirectory::resolve($this->app->basePath()));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());
        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());

        View::composer('components.layouts.site', NavigationComposer::class);

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(Str::transliterate(
                Str::lower($request->string('email')->toString()).'|'.$request->ip()
            ));
        });

        Router::bind('serviceCategory', function (string $value) {
            if (ctype_digit($value)) {
                return ServiceCategory::query()
                    ->with(['translations', 'services.translations'])
                    ->findOrFail($value);
            }

            $locale = Localization::fromRequestPath(request()->path()) ?? Localization::current();

            return app(Catalog::class)->categoryBySlug($value, $locale);
        });

        Router::bind('service', function (string $value, Route $route) {
            if (ctype_digit($value)) {
                return Service::query()
                    ->with(['translations', 'category.translations'])
                    ->findOrFail($value);
            }

            $category = $route->parameter('serviceCategory');

            if (! $category instanceof ServiceCategory) {
                abort(404);
            }

            $locale = Localization::fromRequestPath(request()->path()) ?? Localization::current();
            $service = app(Catalog::class)->serviceBySlug($category, $value, $locale);

            if (! $service instanceof Service) {
                abort(404);
            }

            return $service;
        });
    }
}
