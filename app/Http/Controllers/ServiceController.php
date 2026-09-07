<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Queries\Catalog;
use App\Support\Localization;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Catalog $catalog): View
    {
        $categories = $catalog->categories();

        return view('pages.services.index', [
            'categories' => $categories,
            'metaTitle' => __('seo.services.title'),
            'metaDescription' => __('seo.services.description'),
            'canonical' => Localization::route('services.index'),
        ]);
    }

    public function category(ServiceCategory $serviceCategory): View
    {
        $translation = $serviceCategory->translation();

        abort_if($translation === null, 404);

        return view('pages.services.category', [
            'category' => $serviceCategory,
            'services' => $serviceCategory->services,
            'metaTitle' => $translation->seo_title ?: $translation->name.' | '.__('common.brand'),
            'metaDescription' => $translation->seo_description ?: $translation->excerpt,
            'canonical' => Localization::route('services.category', [
                'serviceCategory' => $translation->slug,
            ]),
        ]);
    }

    public function show(ServiceCategory $serviceCategory, Service $service): View
    {
        abort_unless($service->service_category_id === $serviceCategory->id, 404);

        $translation = $service->translation();
        $categoryTranslation = $serviceCategory->translation();

        abort_if($translation === null || $categoryTranslation === null, 404);

        return view('pages.services.show', [
            'category' => $serviceCategory,
            'service' => $service,
            'related' => $serviceCategory->services
                ->where('id', '!=', $service->id)
                ->take(4)
                ->values(),
            'metaTitle' => $translation->seo_title ?: $translation->name.' | '.__('common.brand'),
            'metaDescription' => $translation->seo_description ?: $translation->excerpt,
            'canonical' => Localization::route('services.show', [
                'serviceCategory' => $categoryTranslation->slug,
                'service' => $translation->slug,
            ]),
        ]);
    }
}
