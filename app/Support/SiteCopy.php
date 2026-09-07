<?php

namespace App\Support;

use App\Enums\Locale;
use App\Models\SiteContent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;

final class SiteCopy
{
    /**
     * @return list<string>
     */
    public static function groups(): array
    {
        return ['home', 'pages', 'legal', 'seo', 'common', 'nav', 'contact'];
    }

    public static function isGroup(string $group): bool
    {
        return in_array($group, self::groups(), true);
    }

    public static function apply(): void
    {
        if (! Schema::hasTable('site_contents')) {
            return;
        }

        foreach (self::overrides() as $locale => $groups) {
            foreach ($groups as $group => $lines) {
                Lang::addLines($lines, $locale, $group);
            }
        }
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function editorFields(string $group): array
    {
        $keys = [];

        foreach (Locale::values() as $locale) {
            $keys = array_replace($keys, self::flatten(self::file($group, $locale)));
        }

        $fields = [];

        foreach (array_keys($keys) as $key) {
            $fields[$key] = [];

            foreach (Locale::values() as $locale) {
                $fields[$key][$locale] = self::current($group, $key, $locale);
            }
        }

        return $fields;
    }

    public static function forget(): void
    {
        Cache::forget('site_contents');
    }

    /**
     * @param  array<string, mixed>  $array
     * @return array<string, string>
     */
    public static function flatten(array $array, string $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $path = $prefix === '' ? (string) $key : $prefix.'.'.$key;

            if (is_array($value)) {
                $result = array_replace($result, self::flatten($value, $path));

                continue;
            }

            $result[$path] = is_scalar($value) || $value === null ? (string) $value : '';
        }

        return $result;
    }

    /**
     * @return array<string, array<string, array<string, mixed>>>
     */
    private static function overrides(): array
    {
        /** @var array<string, array<string, array<string, mixed>>> $overrides */
        $overrides = Cache::rememberForever('site_contents', function () {
            $lines = [];

            foreach (SiteContent::query()->get(['group', 'key', 'locale', 'value']) as $row) {
                Arr::set($lines[$row->locale][$row->group], $row->key, $row->value);
            }

            return $lines;
        });

        return $overrides;
    }

    /**
     * @return array<string, mixed>
     */
    private static function file(string $group, string $locale): array
    {
        $path = lang_path($locale.DIRECTORY_SEPARATOR.$group.'.php');

        if (! is_file($path)) {
            return [];
        }

        $contents = require $path;

        return is_array($contents) ? $contents : [];
    }

    private static function current(string $group, string $key, string $locale): string
    {
        $override = data_get(self::overrides()[$locale][$group] ?? [], $key);

        if (is_string($override)) {
            return $override;
        }

        $fromFile = data_get(self::file($group, $locale), $key);

        return is_scalar($fromFile) || $fromFile === null ? (string) $fromFile : '';
    }
}
