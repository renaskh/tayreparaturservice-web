<x-layouts.admin :title="__('admin.create')">
    @include('admin.services._form', [
        'service' => null,
        'categories' => $categories,
        'action' => route('admin.services.store'),
        'method' => 'POST',
    ])
</x-layouts.admin>
