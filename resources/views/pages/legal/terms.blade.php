@use('App\Support\Company')

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header :title="__('legal.terms.title')" :lead="__('legal.terms.lead')" />

    <article class="tay-shell py-16 lg:py-24">
        <div class="max-w-3xl space-y-10">
            <x-legal-banner />

            @foreach (__('legal.terms.sections') as $section)
                <section>
                    <h2 class="text-xl font-semibold">{{ $section['title'] }}</h2>
                    <p class="mt-3 leading-relaxed text-ink-soft">{{ __($section['text'], Company::replacements()) }}</p>
                </section>
            @endforeach

            <p class="text-sm text-ink-soft">{{ __('common.legal_review') }}</p>
        </div>
    </article>
</x-layouts.site>
