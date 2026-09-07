<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SyncTranslations;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceCategoryRequest;
use App\Http\Requests\Admin\UpdateServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => ServiceCategory::query()->with('translations')->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreServiceCategoryRequest $request, SyncTranslations $sync): RedirectResponse
    {
        DB::transaction(function () use ($request, $sync): void {
            $category = ServiceCategory::query()->create([
                ...$request->safe()->only(['key', 'icon', 'sort_order']),
                'is_active' => $request->boolean('is_active'),
            ]);

            $sync->handle($category, $request->validated('translations'));
        });

        return redirect()->route('admin.categories.index')->with('status', __('admin.saved'));
    }

    public function edit(ServiceCategory $serviceCategory): View
    {
        $serviceCategory->load('translations');
        $serviceCategory->loadCount('services');

        return view('admin.categories.edit', [
            'category' => $serviceCategory,
        ]);
    }

    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $serviceCategory, SyncTranslations $sync): RedirectResponse
    {
        DB::transaction(function () use ($request, $serviceCategory, $sync): void {
            $serviceCategory->update([
                ...$request->safe()->only(['key', 'icon', 'sort_order']),
                'is_active' => $request->boolean('is_active'),
            ]);

            $sync->handle($serviceCategory, $request->validated('translations'));
        });

        return redirect()->route('admin.categories.index')->with('status', __('admin.saved'));
    }

    public function destroy(ServiceCategory $serviceCategory): RedirectResponse
    {
        $serviceCategory->delete();

        return redirect()->route('admin.categories.index')->with('status', __('admin.deleted'));
    }
}
