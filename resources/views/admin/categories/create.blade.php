<x-layouts.admin :title="__('admin.create')">
    @include('admin.categories._form', [
        'category' => null,
        'action' => route('admin.categories.store'),
        'method' => 'POST',
    ])
</x-layouts.admin>
