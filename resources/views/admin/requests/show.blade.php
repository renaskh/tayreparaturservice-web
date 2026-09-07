<x-layouts.admin :title="$serviceRequest->name">
    <div class="flex flex-col gap-3">
        <div class="flex flex-col gap-4 border border-line bg-paper p-5 sm:flex-row sm:items-center sm:justify-between">
            <a class="text-sm font-medium text-petrol underline-offset-4 hover:underline" href="{{ route('admin.requests.index') }}">{{ __('admin.back') }}</a>
            <x-admin.status-badge :status="$serviceRequest->status" />
        </div>

        <dl class="grid gap-6 border border-line bg-paper p-5 sm:grid-cols-2 sm:p-8">
            <div>
                <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('admin.email') }}</dt>
                <dd class="mt-2"><a class="underline-offset-4 hover:underline" href="mailto:{{ $serviceRequest->email }}">{{ $serviceRequest->email }}</a></dd>
            </div>
            <div>
                <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('admin.phone') }}</dt>
                <dd class="mt-2">{{ $serviceRequest->phone ?: __('admin.unspecified') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('admin.company_name') }}</dt>
                <dd class="mt-2">{{ $serviceRequest->company ?: __('admin.unspecified') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('admin.received') }}</dt>
                <dd class="mt-2">{{ $serviceRequest->created_at?->format('d.m.Y H:i') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('admin.category') }}</dt>
                <dd class="mt-2">{{ $serviceRequest->category?->translated('name') ?? __('admin.unspecified') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('admin.services') }}</dt>
                <dd class="mt-2">{{ $serviceRequest->service?->translated('name') ?? __('admin.unspecified') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('admin.locale') }}</dt>
                <dd class="mt-2">{{ $serviceRequest->locale?->label() ?? __('admin.unspecified') }}</dd>
            </div>
        </dl>

        <div class="border border-line bg-paper p-5 sm:p-8">
            <h2 class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('admin.message') }}</h2>
            <p class="mt-3 whitespace-pre-wrap text-sm leading-relaxed">{{ $serviceRequest->message }}</p>
        </div>

        <form method="POST" action="{{ route('admin.requests.update', $serviceRequest) }}" class="max-w-sm border border-line bg-paper p-5 sm:p-8">
            @csrf
            @method('PATCH')
            <label for="status" class="text-sm font-medium">{{ __('admin.status') }}</label>
            <select id="status" name="status" class="tay-field">
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(old('status', $serviceRequest->status->value) === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
            @enderror
            <div class="mt-6">
                <x-button>{{ __('admin.save') }}</x-button>
            </div>
        </form>
    </div>
</x-layouts.admin>
