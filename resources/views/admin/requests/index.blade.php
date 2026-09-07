<x-layouts.admin :title="__('admin.requests')">
    <form method="GET" action="{{ route('admin.requests.index') }}" class="mb-6 border border-line bg-paper p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
            <div class="min-w-0 flex-1">
                <label for="q" class="text-sm font-medium">{{ __('admin.search') }}</label>
                <input id="q" name="q" type="search" value="{{ $search }}" class="tay-field">
            </div>
            <div class="sm:w-56">
                <label for="status" class="text-sm font-medium">{{ __('admin.status') }}</label>
                <select id="status" name="status" class="tay-field">
                    <option value="">{{ __('admin.all_statuses') }}</option>
                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption->value }}" @selected($status === $statusOption->value)>{{ $statusOption->label() }}</option>
                    @endforeach
                </select>
            </div>
            <x-button>{{ __('admin.search') }}</x-button>
        </div>
    </form>

    <section class="border border-line bg-paper">
        @if ($requests->isEmpty())
            <p class="px-5 py-10 text-sm text-ink-soft">{{ __('admin.no_requests') }}</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[40rem] text-left text-sm">
                    <thead class="border-b border-line text-[0.6875rem] tracking-[0.16em] text-ink-soft uppercase">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('admin.name') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('admin.email') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('admin.category') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('admin.status') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('admin.received') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($requests as $serviceRequest)
                            <tr class="align-middle">
                                <td class="px-5 py-4">
                                    <a class="font-medium text-petrol underline-offset-4 hover:underline" href="{{ route('admin.requests.show', $serviceRequest) }}">{{ $serviceRequest->name }}</a>
                                </td>
                                <td class="px-5 py-4 text-ink-soft">{{ $serviceRequest->email }}</td>
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
            <div class="border-t border-line px-5 py-4">{{ $requests->links() }}</div>
        @endif
    </section>
</x-layouts.admin>
