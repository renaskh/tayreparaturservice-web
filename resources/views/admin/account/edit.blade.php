<x-layouts.admin :title="__('admin.account')">
    <form method="POST" action="{{ route('admin.account.update') }}" class="max-w-md space-y-6 border border-line bg-paper p-5 sm:p-8">
        @csrf
        @method('PUT')

        <x-admin.field name="name" :label="__('admin.name')" :value="auth()->user()->name" required maxlength="120" autocomplete="name" />
        <x-admin.field name="email" type="email" :label="__('admin.email')" :value="auth()->user()->email" required maxlength="255" autocomplete="username" />

        <p class="border-t border-line pt-6 text-sm text-ink-soft">{{ __('admin.password_optional') }}</p>

        <x-admin.field name="current_password" type="password" :label="__('admin.current_password')" autocomplete="current-password" />
        <x-admin.field name="password" type="password" :label="__('admin.new_password')" autocomplete="new-password" />
        <x-admin.field name="password_confirmation" type="password" :label="__('admin.password_confirmation')" autocomplete="new-password" />

        <x-button>{{ __('admin.save') }}</x-button>
    </form>
</x-layouts.admin>
