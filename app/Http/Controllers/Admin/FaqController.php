<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SyncTranslations;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFaqRequest;
use App\Http\Requests\Admin\UpdateFaqRequest;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        return view('admin.faqs.index', [
            'faqs' => Faq::query()->with('translations')->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.faqs.create');
    }

    public function store(StoreFaqRequest $request, SyncTranslations $sync): RedirectResponse
    {
        DB::transaction(function () use ($request, $sync): void {
            $faq = Faq::query()->create([
                ...$request->safe()->only(['key', 'sort_order']),
                'is_active' => $request->boolean('is_active'),
            ]);

            $sync->handle($faq, $request->validated('translations'));
        });

        return redirect()->route('admin.faqs.index')->with('status', __('admin.saved'));
    }

    public function edit(Faq $faq): View
    {
        $faq->load('translations');

        return view('admin.faqs.edit', [
            'faq' => $faq,
        ]);
    }

    public function update(UpdateFaqRequest $request, Faq $faq, SyncTranslations $sync): RedirectResponse
    {
        DB::transaction(function () use ($request, $faq, $sync): void {
            $faq->update([
                ...$request->safe()->only(['key', 'sort_order']),
                'is_active' => $request->boolean('is_active'),
            ]);

            $sync->handle($faq, $request->validated('translations'));
        });

        return redirect()->route('admin.faqs.index')->with('status', __('admin.saved'));
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('status', __('admin.deleted'));
    }
}
