<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Random Cat Image API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the Random Cat Image
    | package. You can customize the API endpoint and other settings here.
    |
    */

    'api_url' => env('RANDOM_CAT_API_URL', 'https://api.ai-cats.net/v1/cat'),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure caching options for cat images. Set 'enabled' to true to
    | enable caching and specify the cache duration in minutes.
    |
    */

    'cache' => [
        'enabled' => env('RANDOM_CAT_CACHE_ENABLED', false),
        'duration' => env('RANDOM_CAT_CACHE_DURATION', 60), // minutes
        'key_prefix' => 'random_cat_image_',
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Configuration
    |--------------------------------------------------------------------------
    |
    | Configure HTTP client options for API requests.
    |
    */

    'http' => [
        'timeout' => env('RANDOM_CAT_HTTP_TIMEOUT', 30),
        'user_agent' => env('RANDOM_CAT_USER_AGENT', 'Laravel Random Cat Image Package'),
    ],
];
