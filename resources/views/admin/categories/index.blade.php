<x-layouts.admin :title="__('admin.categories')">
    <div class="flex flex-col gap-4">
        <div>
            <x-button href="{{ route('admin.categories.create') }}">{{ __('admin.create') }}</x-button>
        </div>

        <section class="border border-line bg-paper px-5">
            @if ($categories->isEmpty())
                <p class="py-10 text-sm text-ink-soft">{{ __('admin.empty') }}</p>
            @else
                <ul class="divide-y divide-line">
                    @foreach ($categories as $category)
                        <li class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-medium">{{ $category->translated('name', 'de', $category->key) }}</p>
                                <p class="text-sm text-ink-soft">{{ $category->key }} · {{ $category->is_active ? __('admin.active') : __('admin.inactive') }}</p>
                            </div>
                            <a class="text-sm font-medium text-petrol underline-offset-4 hover:underline" href="{{ route('admin.categories.edit', $category) }}">{{ __('admin.edit') }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</x-layouts.admin>
