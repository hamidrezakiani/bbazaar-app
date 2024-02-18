<?php
return [
    'url' => [
        'APP_URL' => env('APP_URL'),
        'CLIENT_BASE_URL' => env('CLIENT_BASE_URL'),
    ],
    'redirect' => [
        'ORDER_DETAIL_REDIRECT' => '/user/order',
        'FRONTEND_SOCIAL_REDIRECT' => '/social-callback',
        'BACKEND_SOCIAL_REDIRECT' => '/api/v1/user/social-login/callback',
    ],
    'media'  => [
        'STORAGE' => env('MEDIA_STORAGE'),
        'CDN_URL' => env('CDN_URL'),
        'LOCAL' => 'LOCAL',
        'GCS' => 'GCS',
        'URL' => 'URL'
    ]
];
