<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SyncTranslations;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCatalogServiceRequest;
use App\Http\Requests\Admin\UpdateCatalogServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => Service::query()
                ->with(['translations', 'category.translations'])
                ->ordered()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.services.create', [
            'categories' => ServiceCategory::query()->with('translations')->ordered()->get(),
        ]);
    }

    public function store(StoreCatalogServiceRequest $request, SyncTranslations $sync): RedirectResponse
    {
        DB::transaction(function () use ($request, $sync): void {
            $service = Service::query()->create([
                ...$request->safe()->only(['service_category_id', 'key', 'icon', 'sort_order']),
                'is_active' => $request->boolean('is_active'),
            ]);

            $sync->handle($service, $request->validated('translations'), ['features']);
        });

        return redirect()->route('admin.services.index')->with('status', __('admin.saved'));
    }

    public function edit(Service $service): View
    {
        $service->load(['translations', 'category.translations']);

        return view('admin.services.edit', [
            'service' => $service,
            'categories' => ServiceCategory::query()->with('translations')->ordered()->get(),
        ]);
    }

    public function update(UpdateCatalogServiceRequest $request, Service $service, SyncTranslations $sync): RedirectResponse
    {
        DB::transaction(function () use ($request, $service, $sync): void {
            $service->update([
                ...$request->safe()->only(['service_category_id', 'key', 'icon', 'sort_order']),
                'is_active' => $request->boolean('is_active'),
            ]);

            $sync->handle($service, $request->validated('translations'), ['features']);
        });

        return redirect()->route('admin.services.index')->with('status', __('admin.saved'));
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', __('admin.deleted'));
    }
}
