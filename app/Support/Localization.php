<?php

namespace App\Support;

use App\Enums\Locale;
use Illuminate\Support\Facades\Route;

final class Localization
{
    public static function current(): string
    {
        return app()->getLocale();
    }

    /**
     * @return list<string>
     */
    public static function supported(): array
    {
        return Locale::values();
    }

    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::supported(), true);
    }

    public static function default(): string
    {
        return config('localization.default');
    }

    public static function path(string $key, ?string $locale = null): string
    {
        $locale ??= self::current();

        return (string) config('localization.routes.'.$key.'.'.$locale);
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    public static function route(string $name, array $parameters = [], ?string $locale = null, bool $absolute = true): string
    {
        $locale ??= self::current();

        return route($locale.'.'.$name, $parameters, $absolute);
    }

    public static function hasRoute(string $name, ?string $locale = null): bool
    {
        $locale ??= self::current();

        return Route::has($locale.'.'.$name);
    }

    public static function fromRequestPath(string $path): ?string
    {
        $segment = explode('/', ltrim($path, '/'))[0] ?? '';

        if (! is_string($segment) || $segment === '' || ! self::isSupported($segment)) {
            return null;
        }

        return $segment;
    }
}
