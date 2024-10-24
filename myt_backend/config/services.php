<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'wordpress' => [
        'masteryourthoughts.net' => [
            'host'   => env('MYT_NET_WORDPRESS_HOST'),
            'api_me' => env('MYT_NET_WORDPRESS_API_ME', env('MYT_NET_WORDPRESS_HOST') . '/me/'),
            'client_id'     => env('MYT_NET_WORDPRESS_CLIENT_ID'),
            'client_secret' => env('MYT_NET_WORDPRESS_CLIENT_SECRET'),
            'redirect'      => env('MYT_NET_WORDPRESS_REDIRECT'),
        ],
        'wordpress.local' => [
            'host'   => env('WP_LOCAL_WORDPRESS_HOST'),
            'api_me' => env('WP_LOCAL_WORDPRESS_API_ME', env('WP_LOCAL_WORDPRESS_HOST') . '/me/'),
            'client_id'     => env('WP_LOCAL_WORDPRESS_CLIENT_ID'),
            'client_secret' => env('WP_LOCAL_WORDPRESS_CLIENT_SECRET'),
            'redirect'      => env('WP_LOCAL_WORDPRESS_REDIRECT'),
        ],
    ],
];
