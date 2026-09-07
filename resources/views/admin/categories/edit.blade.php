<x-layouts.admin :title="__('admin.edit')">
    @include('admin.categories._form', [
        'category' => $category,
        'action' => route('admin.categories.update', $category),
        'method' => 'PUT',
    ])

    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="mt-10 max-w-3xl border-t border-line pt-8" onsubmit="return confirm(@js(__('admin.confirm_delete_category', ['count' => $category->services_count])))">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm font-medium text-red-800 underline-offset-4 hover:underline">{{ __('admin.delete') }}</button>
    </form>
</x-layouts.admin>
