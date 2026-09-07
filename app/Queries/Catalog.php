<?php

namespace App\Queries;

use App\Models\Faq;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Collection;

class Catalog
{
    /**
     * @return Collection<int, ServiceCategory>
     */
    public function categories(): Collection
    {
        return once(fn () => ServiceCategory::query()
            ->active()
            ->ordered()
            ->with([
                'translations',
                'services' => fn ($query) => $query->active()->ordered(),
                'services.translations',
            ])
            ->get());
    }

    /**
     * @return Collection<int, Faq>
     */
    public function faqs(): Collection
    {
        return once(fn () => Faq::query()
            ->active()
            ->ordered()
            ->with('translations')
            ->get());
    }

    public function categoryBySlug(string $slug, ?string $locale = null): ServiceCategory
    {
        $locale ??= app()->getLocale();

        return ServiceCategory::query()
            ->active()
            ->whereHas('translations', fn ($query) => $query->where('locale', $locale)->where('slug', $slug))
            ->with([
                'translations',
                'services' => fn ($query) => $query->active()->ordered(),
                'services.translations',
            ])
            ->firstOrFail();
    }

    public function serviceBySlug(ServiceCategory $category, string $slug, ?string $locale = null): Service
    {
        $locale ??= app()->getLocale();

        return Service::query()
            ->active()
            ->whereBelongsTo($category, 'category')
            ->whereHas('translations', fn ($query) => $query->where('locale', $locale)->where('slug', $slug))
            ->with(['translations', 'category.translations'])
            ->firstOrFail();
    }
}
