<x-layouts.admin :title="__('admin.create')">
    @include('admin.faqs._form', [
        'faq' => null,
        'action' => route('admin.faqs.store'),
        'method' => 'POST',
    ])
</x-layouts.admin>
