<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(): View
    {
        return view('admin.account.edit');
    }

    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $attributes = $request->safe()->only(['name', 'email']);

        if ($request->filled('password')) {
            $attributes['password'] = $request->validated('password');
        }

        $request->user()->update($attributes);

        return back()->with('status', $request->filled('password')
            ? __('admin.password_changed')
            : __('admin.saved'));
    }
}
