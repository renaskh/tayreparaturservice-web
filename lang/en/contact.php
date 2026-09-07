<?php

return [
    'eyebrow' => 'Contact',
    'title' => 'Contact',
    'lead' => 'Describe your task. We review the enquiry and reply with the next step.',
    'success' => 'Thank you. Your enquiry has been recorded and will be reviewed. This is not yet acceptance of an order.',
    'submit' => 'Send enquiry',
    'error_heading' => 'Please check your details.',
    'required' => 'Required',
    'honeypot' => 'Leave this field empty',
    'fields' => [
        'name' => 'Name',
        'company' => 'Company',
        'email' => 'Email',
        'phone' => 'Phone',
        'category' => 'Service category',
        'service' => 'Service',
        'message' => 'Message',
        'privacy' => 'Privacy',
        'website' => 'Website',
    ],
    'placeholders' => [
        'name' => 'Full name',
        'company' => 'Optional',
        'email' => 'name@company.com',
        'phone' => 'Optional',
        'message' => 'Please describe the device, system or goal and any steps already taken.',
        'category' => 'Please select',
        'service' => 'Optional',
    ],
    'privacy_label' => 'I have read the privacy policy and consent to the processing of my details to handle this enquiry.',
    'privacy_link' => 'Privacy Policy',
    'validation' => [
        'privacy' => 'Please confirm the privacy notice to send the enquiry.',
        'message_min' => 'Please describe your request in at least 20 characters.',
        'service_mismatch' => 'The selected service does not belong to the chosen category.',
    ],
    'aside' => [
        'title' => 'Notes on your enquiry',
        'items' => [
            'The more specific the description, the faster we can classify it.',
            'On-site appointments and remote sessions are arranged separately.',
            'Quotes usually require an inspection or diagnosis.',
        ],
    ],
];
