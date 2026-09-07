<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasTranslations
{
    public function translation(?string $locale = null): ?Model
    {
        $locale ??= app()->getLocale();
        $fallback = config('localization.fallback');

        $translations = $this->relationLoaded('translations')
            ? $this->translations
            : $this->translations()->get();

        return $this->firstTranslation($translations, $locale)
            ?? $this->firstTranslation($translations, $fallback);
    }

    public function translated(string $attribute, ?string $locale = null, mixed $default = null): mixed
    {
        return $this->translation($locale)?->{$attribute} ?? $default;
    }

    /**
     * @param  Collection<int, Model>  $translations
     */
    private function firstTranslation(Collection $translations, string $locale): ?Model
    {
        return $translations->firstWhere('locale', $locale);
    }
}
