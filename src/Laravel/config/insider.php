<?php

return [
    'partner_name' => env('INSIDER_PARTNER_NAME'),
    'api_key' => env('INSIDER_API_KEY'),
    
    'options' => [
        'timeout' => env('INSIDER_TIMEOUT', 30),
        'base_url' => env('INSIDER_API_URL', 'https://api.useinsider.com'),
    ]
];
