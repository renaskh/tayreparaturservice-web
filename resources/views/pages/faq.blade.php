<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header :eyebrow="__('pages.faq.eyebrow')" :title="__('pages.faq.title')" :lead="__('pages.faq.lead')" image="memory-modules" />

    <div class="bg-paper">
        <div class="tay-shell py-16 lg:py-24">
            <div class="max-w-3xl">
                @foreach ($faqs as $faq)
                    @if ($faq->translation())
                        <x-faq-item :question="$faq->translated('question')" :answer="$faq->translated('answer')" />
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.site>
