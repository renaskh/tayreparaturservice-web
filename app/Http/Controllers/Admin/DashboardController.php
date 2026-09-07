<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ServiceRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $statusCounts = $this->statusCounts();

        return view('admin.dashboard', [
            'newRequestCount' => $this->statusCount($statusCounts, ServiceRequestStatus::New),
            'inProgressCount' => $this->statusCount($statusCounts, ServiceRequestStatus::InProgress)
                + $this->statusCount($statusCounts, ServiceRequestStatus::InReview)
                + $this->statusCount($statusCounts, ServiceRequestStatus::Contacted),
            'requestCount' => (int) $statusCounts->sum(),
            'requestsThisWeek' => ServiceRequest::query()
                ->where('created_at', '>=', now()->startOfWeek(CarbonInterface::MONDAY))
                ->count(),
            'serviceCount' => Service::query()->count(),
            'publishedServiceCount' => Service::query()->active()->count(),
            'categoryCount' => ServiceCategory::query()->count(),
            'faqCount' => Faq::query()->count(),
            'statusCounts' => $statusCounts,
            'recentRequests' => ServiceRequest::query()
                ->with(['category.translations', 'service.translations'])
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }

    /**
     * @return Collection<string, int>
     */
    private function statusCounts(): Collection
    {
        $counts = ServiceRequest::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return collect(ServiceRequestStatus::cases())
            ->mapWithKeys(fn (ServiceRequestStatus $status): array => [
                $status->value => (int) $counts->get($status->value, 0),
            ]);
    }

    /**
     * @param  Collection<string, int>  $statusCounts
     */
    private function statusCount(Collection $statusCounts, ServiceRequestStatus $status): int
    {
        return (int) $statusCounts->get($status->value, 0);
    }
}
