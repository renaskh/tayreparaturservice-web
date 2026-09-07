<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header :title="__('legal.privacy.title')" :lead="__('legal.privacy.lead')" />

    <article class="tay-shell py-16 text-ink-soft lg:py-24">
        <div class="max-w-3xl space-y-10">
            <x-legal-banner />

            @foreach ([
                'controller', 'hosting', 'logs', 'forms', 'cookies', 'fonts', 'third_parties', 'retention', 'rights', 'contact_dpo',
            ] as $section)
                <section>
                    <h2 class="text-xl font-semibold text-ink">{{ __('legal.privacy.'.$section) }}</h2>
                    <p class="mt-3 leading-relaxed">{{ __('legal.privacy.'.$section.'_text') }}</p>
                </section>
            @endforeach
        </div>
    </article>
</x-layouts.site>
