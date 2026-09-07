<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCompanyRequest;
use App\Models\Setting;
use App\Support\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function edit(): View
    {
        return view('admin.company.edit', [
            'values' => Company::values(),
        ]);
    }

    public function update(UpdateCompanyRequest $request): RedirectResponse
    {
        Setting::putMany($request->safe()->only(Company::keys()));

        return back()->with('status', __('admin.saved'));
    }
}
