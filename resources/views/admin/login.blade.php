<x-layouts.admin-guest :title="__('admin.login_title')">
    <div class="flex min-h-screen items-center justify-center px-5 py-16">
        <div class="w-full max-w-md border border-white/10 bg-ink-mid p-8">
            <p class="tay-kicker text-signal">{{ __('common.brand') }}</p>
            <h1 class="mt-4 text-3xl font-semibold tracking-[-0.03em]">{{ __('admin.login_title') }}</h1>
            <p class="mt-3 text-sm leading-relaxed text-paper/65">{{ __('admin.login_lead') }}</p>

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 space-y-6">
                @csrf
                <div>
                    <label for="email" class="text-xs font-semibold tracking-[0.18em] text-paper/50 uppercase">{{ __('admin.email') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="tay-field border-white/20 text-paper">
                    @error('email')
                        <p class="mt-2 text-sm text-signal">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="text-xs font-semibold tracking-[0.18em] text-paper/50 uppercase">{{ __('admin.password') }}</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" class="tay-field border-white/20 text-paper">
                </div>
                <label class="flex items-center gap-2 text-sm text-paper/70">
                    <input type="checkbox" name="remember" value="1" class="border-white/30">
                    {{ __('admin.remember') }}
                </label>
                <x-button variant="invert" class="w-full">{{ __('admin.sign_in') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.admin-guest>
