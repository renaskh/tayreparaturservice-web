@use('App\Support\Company')

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical" :robots="$robots ?? 'index, follow'">
    <x-page-header :title="__('legal.imprint.title')" :lead="__('legal.imprint.lead')" />

    <article class="tay-shell py-16 lg:py-24">
        <div class="max-w-3xl space-y-12">
            <dl>
                <div class="border-b border-line py-4">
                    <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('legal.imprint.provider') }}</dt>
                    <dd class="mt-1">{{ Company::value('legal_name') }}</dd>
                </div>
                <x-legal-field :label="__('legal.imprint.legal_form')" key="legal_form" />
                <div class="border-b border-line py-4">
                    <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('legal.imprint.brand') }}</dt>
                    <dd class="mt-1">{{ __('common.brand') }}</dd>
                </div>
                <x-legal-field :label="__('legal.imprint.owner')" key="owner" />
                <div class="border-b border-line py-4">
                    <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('legal.imprint.address') }}</dt>
                    <dd class="mt-1">
                        {{ Company::value('street') }}<br>
                        {{ Company::value('postal_code') }} {{ Company::value('city') }}<br>
                        {{ Company::value('country') }}
                    </dd>
                </div>
                <div class="border-b border-line py-4">
                    <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('contact.fields.phone') }}</dt>
                    <dd class="mt-1">
                        <a class="underline-offset-2 hover:underline" href="{{ Company::telHref() }}">{{ Company::value('phone') }}</a>
                    </dd>
                </div>
                <div class="border-b border-line py-4">
                    <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('contact.fields.email') }}</dt>
                    <dd class="mt-1">
                        <a class="underline-offset-2 hover:underline" href="mailto:{{ Company::value('email') }}">{{ Company::value('email') }}</a>
                    </dd>
                </div>
                @if (Company::has('website'))
                    <div class="border-b border-line py-4">
                        <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('legal.imprint.website') }}</dt>
                        <dd class="mt-1">
                            <a class="underline-offset-2 hover:underline" href="{{ Company::value('website') }}" rel="noopener noreferrer">{{ Company::value('website') }}</a>
                        </dd>
                    </div>
                @endif
                <x-legal-field :label="__('legal.imprint.vat')" key="vat_id" />
                <x-legal-field :label="__('legal.imprint.register_court')" key="register_court" />
                <x-legal-field :label="__('legal.imprint.register_number')" key="register_number" />
                <div class="border-b border-line py-4">
                    <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ __('legal.imprint.responsible') }}</dt>
                    <dd class="mt-1">
                        {{ Company::value('responsible') }}<br>
                        {{ Company::value('street') }}<br>
                        {{ Company::value('postal_code') }} {{ Company::value('city') }}<br>
                        {{ Company::value('country') }}
                    </dd>
                </div>
            </dl>

            <section class="space-y-3">
                <h2 class="text-xl font-semibold tracking-[-0.02em]">{{ __('legal.imprint.odr_title') }}</h2>
                <p class="leading-relaxed text-ink-soft">{{ __('legal.imprint.odr_text') }}</p>
                <p>
                    <a class="text-petrol underline-offset-2 hover:underline" href="{{ __('legal.imprint.odr_url') }}" rel="noopener noreferrer">{{ __('legal.imprint.odr_url') }}</a>
                </p>
                <p class="leading-relaxed text-ink-soft">{{ __('legal.imprint.odr_email') }}</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-semibold tracking-[-0.02em]">{{ __('legal.imprint.vsb_title') }}</h2>
                <p class="leading-relaxed text-ink-soft">{{ __('legal.imprint.vsb_text') }}</p>
            </section>
        </div>
    </article>
</x-layouts.site>
