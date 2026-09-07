@props([
    'title',
    'description',
    'canonical',
    'alternates' => [],
    'robots' => 'index, follow',
    'ogType' => 'website',
])

@php
    $defaultLocale = \App\Support\Localization::default();
    $organization = [
        '@type' => 'ProfessionalService',
        '@id' => url('/').'#organization',
        'name' => __('common.brand'),
        'legalName' => \App\Support\Company::value('legal_name', ''),
        'url' => \App\Support\Localization::route('home', [], $defaultLocale),
        'inLanguage' => array_values(config('localization.hreflang')),
    ];

    if (\App\Support\Company::has('email')) {
        $organization['email'] = \App\Support\Company::value('email');
    }

    if (\App\Support\Company::has('phone')) {
        $organization['telephone'] = \App\Support\Company::value('phone');
    }

    if (\App\Support\Company::has('street') && \App\Support\Company::has('city')) {
        $organization['address'] = [
            '@type' => 'PostalAddress',
            'streetAddress' => \App\Support\Company::value('street'),
            'postalCode' => \App\Support\Company::value('postal_code'),
            'addressLocality' => \App\Support\Company::value('city'),
            'addressCountry' => \App\Support\Company::value('country'),
        ];
    }

    $jsonLd = [
        '@context' => 'https://schema.org',
        '@graph' => [
            $organization,
            [
                '@type' => 'WebSite',
                '@id' => url('/').'#website',
                'url' => url('/'),
                'name' => __('common.brand'),
                'publisher' => ['@id' => url('/').'#organization'],
                'inLanguage' => config('localization.hreflang.'.app()->getLocale()),
            ],
        ],
    ];
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonical }}">

@foreach ($alternates as $locale => $url)
    <link rel="alternate" hreflang="{{ config('localization.hreflang.'.$locale, $locale) }}" href="{{ $url }}">
@endforeach
@if (isset($alternates[$defaultLocale]))
    <link rel="alternate" hreflang="x-default" href="{{ $alternates[$defaultLocale] }}">
@endif

<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="{{ __('common.brand') }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ \App\Support\SiteMedia::absoluteJpgUrl('infrastructure-servers') }}">
<meta property="og:image:alt" content="{{ __('media.alt.infrastructure-servers') }}">
<meta property="og:locale" content="{{ str_replace('-', '_', config('localization.hreflang.'.app()->getLocale(), app()->getLocale())) }}">
@foreach ($alternates as $locale => $url)
    @if ($locale !== app()->getLocale())
        <meta property="og:locale:alternate" content="{{ str_replace('-', '_', config('localization.hreflang.'.$locale, $locale)) }}">
    @endif
@endforeach

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ \App\Support\SiteMedia::absoluteJpgUrl('infrastructure-servers') }}">

<script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
