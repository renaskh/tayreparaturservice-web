@use('App\Support\Company')

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header :title="__('legal.withdrawal.title')" :lead="__('legal.withdrawal.lead')" />

    <article class="tay-shell py-16 lg:py-24">
        <div class="max-w-3xl space-y-6">
            <x-legal-banner />

            @foreach (__('legal.withdrawal.body') as $paragraph)
                <p class="leading-relaxed text-ink-soft">{{ __($paragraph, Company::replacements()) }}</p>
            @endforeach

            <p class="bg-paper-2 px-4 py-4 text-sm text-ink-soft">{{ __('legal.withdrawal.model', Company::replacements()) }}</p>
            <p class="text-sm text-ink-soft">{{ __('common.legal_review') }}</p>
        </div>
    </article>
</x-layouts.site>
