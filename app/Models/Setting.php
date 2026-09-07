<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value'])]
class Setting extends Model
{
    /**
     * @return array<string, string|null>
     */
    public static function dictionary(): array
    {
        /** @var array<string, string|null> $values */
        $values = Cache::rememberForever('settings', function () {
            return static::query()->pluck('value', 'key')->all();
        });

        return $values;
    }

    public static function get(string $key): ?string
    {
        $value = self::dictionary()[$key] ?? null;

        return $value === null ? null : (string) $value;
    }

    /**
     * @param  array<string, string|null>  $values
     */
    public static function putMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }

        Cache::forget('settings');
    }
}
