@use('App\Enums\ServiceRequestStatus')

@php
    $hour = now()->timezone(config('app.timezone'))->hour;
    $greeting = match (true) {
        $hour < 12 => __('admin.greeting_morning'),
        $hour < 18 => __('admin.greeting_afternoon'),
        default => __('admin.greeting_evening'),
    };
    $statusTotal = max((int) $statusCounts->sum(), 1);
@endphp

<x-layouts.admin :title="__('admin.dashboard')">
    <section class="flex flex-col gap-3 border border-line bg-ink px-5 py-6 text-paper sm:flex-row sm:items-end sm:justify-between sm:px-6">
        <div>
            <p class="tay-kicker text-signal">{{ now()->timezone(config('app.timezone'))->isoFormat('dddd, D. MMMM YYYY') }}</p>
            <h2 class="mt-3 text-2xl font-semibold tracking-[-0.03em] sm:text-3xl">{{ $greeting }}, {{ auth()->user()->name }}</h2>
            <p class="mt-2 max-w-xl text-sm leading-relaxed text-paper/65">{{ __('admin.dashboard_lead') }}</p>
        </div>
        <x-button href="{{ route('admin.requests.index', ['status' => 'new']) }}" variant="invert">
            {{ __('admin.open_inbox') }}
        </x-button>
    </section>

    <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat
            :label="__('admin.new_requests')"
            :value="$newRequestCount"
            :hint="__('admin.new_requests_hint')"
            icon="inbox"
            :href="route('admin.requests.index', ['status' => 'new'])"
        />
        <x-admin.stat
            :label="__('admin.open_work')"
            :value="$inProgressCount"
            :hint="__('admin.open_work_hint')"
            icon="sliders"
            :href="route('admin.requests.index')"
        />
        <x-admin.stat
            :label="__('admin.this_week')"
            :value="$requestsThisWeek"
            :hint="__('admin.this_week_hint', ['total' => $requestCount])"
            icon="clipboard"
        />
        <x-admin.stat
            :label="__('admin.published_services')"
            :value="$publishedServiceCount"
            :hint="__('admin.published_services_hint', ['services' => $serviceCount, 'categories' => $categoryCount, 'faqs' => $faqCount])"
            icon="layers"
            :href="route('admin.services.index')"
        />
    </div>

    <div class="mt-6 grid gap-3 xl:grid-cols-[minmax(0,1.4fr)_minmax(18rem,0.8fr)]">
        <section class="border border-line bg-paper">
            <div class="flex flex-col gap-3 border-b border-line px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold tracking-[-0.02em]">{{ __('admin.recent_requests') }}</h2>
                    <p class="mt-1 text-sm text-ink-soft">{{ __('admin.recent_requests_lead') }}</p>
                </div>
                <x-button href="{{ route('admin.requests.index') }}" variant="secondary">{{ __('admin.view_all') }}</x-button>
            </div>

            @if ($recentRequests->isEmpty())
                <p class="px-5 py-10 text-sm text-ink-soft">{{ __('admin.no_requests') }}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[36rem] text-left text-sm">
                        <thead class="border-b border-line text-[0.6875rem] tracking-[0.16em] text-ink-soft uppercase">
                            <tr>
                                <th class="px-5 py-3 font-medium">{{ __('admin.name') }}</th>
                                <th class="px-5 py-3 font-medium">{{ __('admin.category') }}</th>
                                <th class="px-5 py-3 font-medium">{{ __('admin.status') }}</th>
                                <th class="px-5 py-3 font-medium">{{ __('admin.received') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line">
                            @foreach ($recentRequests as $serviceRequest)
                                <tr class="align-middle">
                                    <td class="px-5 py-4">
                                        <a class="font-medium text-petrol underline-offset-4 hover:underline" href="{{ route('admin.requests.show', $serviceRequest) }}">{{ $serviceRequest->name }}</a>
                                        <p class="mt-1 text-ink-soft">{{ $serviceRequest->email }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-ink-soft">{{ $serviceRequest->category?->translated('name') ?? __('admin.unspecified') }}</td>
                                    <td class="px-5 py-4">
                                        <x-admin.status-badge :status="$serviceRequest->status" />
                                    </td>
                                    <td class="px-5 py-4 text-ink-soft">
                                        <time datetime="{{ $serviceRequest->created_at?->toIso8601String() }}">{{ $serviceRequest->created_at?->timezone(config('app.timezone'))->format('d.m.Y H:i') }}</time>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <div class="flex flex-col gap-3">
            <section class="border border-line bg-paper p-5">
                <h2 class="text-lg font-semibold tracking-[-0.02em]">{{ __('admin.status_overview') }}</h2>
                <p class="mt-1 text-sm text-ink-soft">{{ __('admin.status_overview_lead') }}</p>
                <ul class="mt-5 space-y-4">
                    @foreach (ServiceRequestStatus::cases() as $status)
                        @php
                            $count = (int) $statusCounts->get($status->value, 0);
                            $percent = (int) round(($count / $statusTotal) * 100);
                        @endphp
                        <li>
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <a class="hover:text-petrol" href="{{ route('admin.requests.index', ['status' => $status->value]) }}">{{ $status->label() }}</a>
                                <span class="tabular-nums text-ink-soft">{{ $count }}</span>
                            </div>
                            <div class="mt-2 h-1 bg-line">
                                <div class="h-1 bg-petrol" style="width: {{ $percent }}%"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="border border-line bg-paper p-5">
                <h2 class="text-lg font-semibold tracking-[-0.02em]">{{ __('admin.quick_actions') }}</h2>
                <ul class="mt-4 divide-y divide-line border-y border-line text-sm">
                    <li>
                        <a class="flex items-center justify-between gap-3 py-3 hover:text-petrol" href="{{ route('admin.faqs.create') }}">
                            <span>{{ __('admin.quick_faq') }}</span>
                            <x-icon name="plus" class="h-4 w-4" />
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center justify-between gap-3 py-3 hover:text-petrol" href="{{ route('admin.company.edit') }}">
                            <span>{{ __('admin.quick_company') }}</span>
                            <x-icon name="building" class="h-4 w-4" />
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center justify-between gap-3 py-3 hover:text-petrol" href="{{ route('admin.pages.index') }}">
                            <span>{{ __('admin.quick_pages') }}</span>
                            <x-icon name="file" class="h-4 w-4" />
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center justify-between gap-3 py-3 hover:text-petrol" href="{{ url('/de') }}">
                            <span>{{ __('admin.view_site') }}</span>
                            <x-icon name="globe" class="h-4 w-4" />
                        </a>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</x-layouts.admin>
