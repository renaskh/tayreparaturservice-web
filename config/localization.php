<?php

return [

    'default' => 'de',

    'fallback' => 'de',

    'supported' => ['de', 'en'],

    'names' => [
        'de' => 'Deutsch',
        'en' => 'English',
    ],

    'hreflang' => [
        'de' => 'de-DE',
        'en' => 'en',
    ],

    /*
    |--------------------------------------------------------------------------
    | Localized path segments
    |--------------------------------------------------------------------------
    |
    | Public URL segments per locale. Route names stay locale-prefixed, e.g.
    | de.services.index and en.services.index.
    |
    */
    'routes' => [
        'services' => ['de' => 'leistungen', 'en' => 'services'],
        'about' => ['de' => 'ueber-uns', 'en' => 'about'],
        'business' => ['de' => 'fuer-unternehmen', 'en' => 'for-businesses'],
        'faq' => ['de' => 'faq', 'en' => 'faq'],
        'contact' => ['de' => 'kontakt', 'en' => 'contact'],
        'imprint' => ['de' => 'impressum', 'en' => 'imprint'],
        'privacy' => ['de' => 'datenschutz', 'en' => 'privacy'],
        'terms' => ['de' => 'agb', 'en' => 'terms'],
        'withdrawal' => ['de' => 'widerruf', 'en' => 'withdrawal'],
    ],

];
