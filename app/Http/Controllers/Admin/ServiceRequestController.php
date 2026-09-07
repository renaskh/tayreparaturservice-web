<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ServiceRequestStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateServiceRequestStatusRequest;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = ServiceRequestStatus::tryFrom((string) $request->query('status', ''));
        $search = trim((string) $request->query('q', ''));

        $requests = ServiceRequest::query()
            ->with(['category.translations', 'service.translations'])
            ->when($status instanceof ServiceRequestStatus, fn (Builder $query): Builder => $query->where('status', $status))
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('company', 'like', '%'.$search.'%');
                });
            })
            ->latest()
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.requests.index', [
            'requests' => $requests,
            'status' => $status?->value,
            'search' => $search,
            'statuses' => ServiceRequestStatus::cases(),
        ]);
    }

    public function show(ServiceRequest $serviceRequest): View
    {
        $serviceRequest->load(['category.translations', 'service.translations']);

        return view('admin.requests.show', [
            'serviceRequest' => $serviceRequest,
            'statuses' => ServiceRequestStatus::cases(),
        ]);
    }

    public function update(UpdateServiceRequestStatusRequest $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->update($request->safe()->only(['status']));

        return back()->with('status', __('admin.saved'));
    }
}
