<?php

namespace App\Support;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;

final class AlternateUrls
{
    /**
     * @return array<string, string>
     */
    public function forCurrentRoute(): array
    {
        $route = request()->route();

        if (! $route instanceof Route) {
            return [];
        }

        $name = $route->getName();

        if (! is_string($name) || ! str_contains($name, '.')) {
            return [];
        }

        $baseName = preg_replace('/^(de|en)\./', '', $name);

        if (! is_string($baseName) || $baseName === '') {
            return [];
        }

        $urls = [];

        foreach (Localization::supported() as $locale) {
            if (! Localization::hasRoute($baseName, $locale)) {
                continue;
            }

            $urls[$locale] = Localization::route(
                $baseName,
                $this->parametersForLocale($route->parameters(), $locale),
                $locale,
            );
        }

        return $urls;
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    private function parametersForLocale(array $parameters, string $locale): array
    {
        $translated = [];

        foreach ($parameters as $key => $value) {
            if ($value instanceof ServiceCategory || $value instanceof Service) {
                $translated[$key] = $value->translated('slug', $locale);

                continue;
            }

            if ($value instanceof Model) {
                $translated[$key] = $value->getRouteKey();

                continue;
            }

            $translated[$key] = $value;
        }

        return $translated;
    }
}
