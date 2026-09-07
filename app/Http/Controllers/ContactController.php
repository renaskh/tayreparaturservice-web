<?php

namespace App\Http\Controllers;

use App\Actions\CreateServiceRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Queries\Catalog;
use App\Support\Localization;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(Catalog $catalog): View
    {
        $categories = $catalog->categories();

        return view('pages.contact', [
            'categories' => $categories,
            'serviceMap' => $categories->mapWithKeys(fn ($category) => [
                $category->id => $category->services->map(fn ($service) => [
                    'id' => $service->id,
                    'name' => $service->translated('name'),
                ])->values(),
            ]),
            'metaTitle' => __('seo.contact.title'),
            'metaDescription' => __('seo.contact.description'),
            'canonical' => Localization::route('contact.create'),
        ]);
    }

    public function store(StoreServiceRequest $request, CreateServiceRequest $action): RedirectResponse
    {
        if ($request->filled('website')) {
            return redirect()
                ->route(app()->getLocale().'.contact.create')
                ->with('status', __('contact.success'));
        }

        $action->handle([
            ...$request->safe()->only([
                'name',
                'company',
                'email',
                'phone',
                'service_category_id',
                'service_id',
                'message',
            ]),
            'locale' => app()->getLocale(),
        ]);

        return redirect()
            ->route(app()->getLocale().'.contact.create')
            ->with('status', __('contact.success'));
    }
}
