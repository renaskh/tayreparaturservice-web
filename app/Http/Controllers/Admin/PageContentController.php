<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePageContentRequest;
use App\Support\SiteCopy;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageContentController extends Controller
{
    public function index(): View
    {
        return view('admin.pages.index', [
            'groups' => SiteCopy::groups(),
        ]);
    }

    public function edit(string $group): View
    {
        abort_unless(SiteCopy::isGroup($group), 404);

        return view('admin.pages.edit', [
            'group' => $group,
            'fields' => SiteCopy::editorFields($group),
        ]);
    }

    public function update(UpdatePageContentRequest $request, string $group): RedirectResponse
    {
        abort_unless(SiteCopy::isGroup($group), 404);

        SiteCopy::saveGroup($group, $request->validated('contents'));

        return redirect()->route('admin.pages.edit', $group)->with('status', __('admin.saved'));
    }
}
