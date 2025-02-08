<?php
return [
    'app' => [
        'name' => 'BongSo1',
        'url' => 'http://localhost:8000',
        'env' => 'local', // local, staging, production
    ],
    
    'database' => [
        'local' => [
            'host' => 'db',
            'name' => 'bongso1_db',
            'user' => 'bongso1_user',
            'pass' => 'userpassword'
        ],
        'production' => [
            'host' => 'YOUR_HOSTINGER_HOST',
            'name' => 'YOUR_HOSTINGER_DB',
            'user' => 'YOUR_HOSTINGER_USER',
            'pass' => 'YOUR_HOSTINGER_PASSWORD'
        ]
    ],

    'auth' => [
        'password_min_length' => 8,
        'session_lifetime' => 7200, // 2 hours
        'remember_me_lifetime' => 2592000, // 30 days
        'jwt_secret' => '59c1cdf2eac15a05433b4c45f9a7481245175c2734214774236ea8b2029a3012',
    ],

    'social' => [
        'google' => [
            'client_id' => '9778201340-nm14o70cjj704nobrkbe9838dhtkrhuh.apps.googleusercontent.com',
            'client_secret' => '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',
            'redirect_uri' => '/auth/google/callback'
        ],
        'facebook' => [
            'app_id' => 'YOUR_FACEBOOK_APP_ID',
            'app_secret' => 'YOUR_FACEBOOK_APP_SECRET',
            'redirect_uri' => '/auth/facebook/callback'
        ]
    ]
];
