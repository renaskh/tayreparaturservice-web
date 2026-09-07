@use('App\Support\Company')

<x-layouts.admin :title="__('admin.company')">
    <form method="POST" action="{{ route('admin.company.update') }}" class="max-w-3xl space-y-6 border border-line bg-paper p-5 sm:p-8">
        @csrf
        @method('PUT')

        @foreach (Company::keys() as $key)
            @if ($key === 'legal_form' || $key === 'responsible' || $key === 'hosting_provider')
                <x-admin.textarea
                    :name="$key"
                    :label="__('admin.company_fields.'.$key)"
                    :value="$values[$key] ?? ''"
                    :rows="3"
                />
            @else
                <x-admin.field
                    :name="$key"
                    :type="$key === 'email' ? 'email' : ($key === 'website' ? 'url' : 'text')"
                    :label="__('admin.company_fields.'.$key)"
                    :value="$values[$key] ?? ''"
                    maxlength="255"
                />
            @endif
        @endforeach

        <x-button>{{ __('admin.save') }}</x-button>
    </form>
</x-layouts.admin>
