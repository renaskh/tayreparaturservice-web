@use('App\Support\Company')
@use('App\Support\Localization')

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header :eyebrow="__('contact.eyebrow')" :title="__('contact.title')" :lead="__('contact.lead')" image="code-review" />

    <div class="bg-paper">
        <div class="tay-shell grid gap-12 py-16 lg:grid-cols-[minmax(0,1.2fr)_minmax(16rem,0.8fr)] lg:py-24">
            <div>
                @if ($errors->any())
                    <div class="mb-8 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                        <p class="font-medium">{{ __('contact.error_heading') }}</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <p class="mb-8 bg-accent-soft px-4 py-3 text-sm text-accent-strong" role="status">
                        {{ session('status') }}
                    </p>
                @endif

                <form method="POST" action="{{ Localization::route('contact.store') }}" class="space-y-6" novalidate>
                    @csrf

                    <div class="absolute -left-[9999px] h-px w-px overflow-hidden" aria-hidden="true">
                        <label for="website">{{ __('contact.honeypot') }}</label>
                        <input id="website" type="text" name="website" value="{{ old('website') }}" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="text-sm font-medium">{{ __('contact.fields.name') }} <span class="text-petrol">*</span></label>
                            <input id="name" name="name" type="text" required maxlength="120" value="{{ old('name') }}" placeholder="{{ __('contact.placeholders.name') }}" autocomplete="name" class="tay-field">
                            @error('name') <p class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="company" class="text-sm font-medium">{{ __('contact.fields.company') }}</label>
                            <input id="company" name="company" type="text" maxlength="160" value="{{ old('company') }}" placeholder="{{ __('contact.placeholders.company') }}" autocomplete="organization" class="tay-field">
                            @error('company') <p class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="email" class="text-sm font-medium">{{ __('contact.fields.email') }} <span class="text-petrol">*</span></label>
                            <input id="email" name="email" type="email" required maxlength="255" value="{{ old('email') }}" placeholder="{{ __('contact.placeholders.email') }}" autocomplete="email" class="tay-field">
                            @error('email') <p class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="text-sm font-medium">{{ __('contact.fields.phone') }}</label>
                            <input id="phone" name="phone" type="tel" maxlength="50" value="{{ old('phone') }}" placeholder="{{ __('contact.placeholders.phone') }}" autocomplete="tel" class="tay-field">
                            @error('phone') <p class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2" data-service-map="{{ e(json_encode($serviceMap)) }}">
                        <div>
                            <label for="service_category_id" class="text-sm font-medium">{{ __('contact.fields.category') }}</label>
                            <select id="service_category_id" name="service_category_id" data-category-select class="tay-field">
                                <option value="">{{ __('contact.placeholders.category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('service_category_id') == $category->id)>{{ $category->translated('name') }}</option>
                                @endforeach
                            </select>
                            @error('service_category_id') <p class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="service_id" class="text-sm font-medium">{{ __('contact.fields.service') }}</label>
                            <select id="service_id" name="service_id" data-service-select data-placeholder="{{ __('contact.placeholders.service') }}" class="tay-field">
                                <option value="">{{ __('contact.placeholders.service') }}</option>
                                @foreach ($categories as $category)
                                    @foreach ($category->services as $service)
                                        <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->translated('name') }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('service_id') <p class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="text-sm font-medium">{{ __('contact.fields.message') }} <span class="text-petrol">*</span></label>
                        <textarea id="message" name="message" required minlength="20" maxlength="5000" rows="7" placeholder="{{ __('contact.placeholders.message') }}" class="tay-field">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="flex items-start gap-3 text-sm leading-relaxed">
                            <input id="privacy_consent" type="checkbox" name="privacy_consent" value="1" @checked(old('privacy_consent')) class="mt-1 border-line">
                            <div>
                                <label for="privacy_consent">{{ __('contact.privacy_label') }}</label>
                                <a class="text-petrol underline-offset-2 hover:underline" href="{{ Localization::route('legal.privacy') }}">{{ __('contact.privacy_link') }}</a>
                            </div>
                        </div>
                        @error('privacy_consent') <p class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                    </div>

                    <x-button>{{ __('contact.submit') }}</x-button>
                </form>
            </div>

            <aside class="h-fit bg-ink px-6 py-8 text-paper">
                <h2 class="text-lg font-semibold tracking-[-0.02em]">{{ __('contact.aside.title') }}</h2>
                @if (Company::has('email') || Company::has('phone'))
                    <dl class="mt-6 space-y-3 text-sm text-paper/80">
                        @if (Company::has('phone'))
                            <div>
                                <dt class="text-xs tracking-[0.18em] text-paper/40 uppercase">{{ __('contact.fields.phone') }}</dt>
                                <dd class="mt-1"><a class="hover:text-paper" href="{{ Company::telHref() }}">{{ Company::value('phone') }}</a></dd>
                            </div>
                        @endif
                        @if (Company::has('email'))
                            <div>
                                <dt class="text-xs tracking-[0.18em] text-paper/40 uppercase">{{ __('contact.fields.email') }}</dt>
                                <dd class="mt-1"><a class="hover:text-paper" href="mailto:{{ Company::value('email') }}">{{ Company::value('email') }}</a></dd>
                            </div>
                        @endif
                    </dl>
                @endif
                <ul class="mt-6 divide-y divide-white/10 border-y border-white/10 text-sm text-paper/70">
                    @foreach (__('contact.aside.items') as $item)
                        <li class="py-4">{{ $item }}</li>
                    @endforeach
                </ul>
            </aside>
        </div>
    </div>
</x-layouts.site>
