<?php

return [

    'name' => env('COMPANY_NAME') ?: 'Tay Reparaturservice',

    'legal_name' => env('COMPANY_LEGAL_NAME') ?: 'Enes Handy Reparatur',

    'legal_form' => env('COMPANY_LEGAL_FORM') ?: 'Einzelunternehmen',

    'owner' => env('COMPANY_OWNER') ?: 'Kübra Tay',

    'street' => env('COMPANY_STREET') ?: 'Rosenstraße 19',

    'postal_code' => env('COMPANY_POSTAL_CODE') ?: '63450',

    'city' => env('COMPANY_CITY') ?: 'Hanau',

    'country' => env('COMPANY_COUNTRY') ?: 'Deutschland',

    'email' => env('COMPANY_EMAIL') ?: 'info@eneshandyreparatur.de',

    'phone' => env('COMPANY_PHONE') ?: '+49 163 3609131',

    'website' => env('COMPANY_WEBSITE') ?: 'https://www.eneshandyreparatur.de',

    'vat_id' => env('COMPANY_VAT_ID') ?: 'DE347824732',

    'register_court' => env('COMPANY_REGISTER_COURT'),

    'register_number' => env('COMPANY_REGISTER_NUMBER'),

    'responsible' => env('COMPANY_RESPONSIBLE') ?: 'Kübra Tay',

    'hosting_provider' => env('COMPANY_HOSTING_PROVIDER'),

];
