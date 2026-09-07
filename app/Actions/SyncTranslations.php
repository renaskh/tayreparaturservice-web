<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

class SyncTranslations
{
    /**
     * @param  array<string, array<string, mixed>>  $translations
     * @param  list<string>  $lineFields
     */
    public function handle(Model $model, array $translations, array $lineFields = []): void
    {
        foreach ($translations as $locale => $attributes) {
            foreach ($lineFields as $field) {
                if (! array_key_exists($field, $attributes) || ! is_string($attributes[$field])) {
                    continue;
                }

                $attributes[$field] = self::lines($attributes[$field]);
            }

            $model->translations()->updateOrCreate(
                ['locale' => $locale],
                $attributes,
            );
        }
    }

    /**
     * @return list<string>
     */
    public static function lines(string $value): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $value) ?: [];

        return array_values(array_filter(array_map(trim(...), $lines), fn (string $line): bool => $line !== ''));
    }

    /**
     * @param  list<string>|null  $items
     */
    public static function textarea(?array $items): string
    {
        return implode("\n", $items ?? []);
    }
}
