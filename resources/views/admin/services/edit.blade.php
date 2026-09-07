<x-layouts.admin :title="__('admin.edit')">
    @include('admin.services._form', [
        'service' => $service,
        'categories' => $categories,
        'action' => route('admin.services.update', $service),
        'method' => 'PUT',
    ])

    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="mt-10 max-w-3xl border-t border-line pt-8" onsubmit="return confirm(@js(__('admin.confirm_delete')))">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm font-medium text-red-800 underline-offset-4 hover:underline">{{ __('admin.delete') }}</button>
    </form>
</x-layouts.admin>
