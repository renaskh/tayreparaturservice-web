<x-layouts.admin :title="__('admin.pages')">
    <section class="border border-line bg-paper px-5">
        <ul class="divide-y divide-line">
            @foreach ($groups as $group)
                <li class="flex items-center justify-between py-4">
                    <p class="font-medium">{{ __('admin.page_groups.'.$group) }}</p>
                    <a class="text-sm font-medium text-petrol underline-offset-4 hover:underline" href="{{ route('admin.pages.edit', $group) }}">{{ __('admin.edit') }}</a>
                </li>
            @endforeach
        </ul>
    </section>
</x-layouts.admin>
