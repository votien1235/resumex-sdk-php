<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ResumeX API Credentials
    |--------------------------------------------------------------------------
    |
    | Your ResumeX API credentials. You can find these in your Partner Dashboard
    | at https://partners.resumex.com/dashboard
    |
    */
    'api_key' => env('RESUMEX_API_KEY', ''),
    'api_secret' => env('RESUMEX_API_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | The environment to use: 'production' or 'sandbox'
    | Use 'sandbox' for testing without affecting production data or quotas
    |
    */
    'environment' => env('RESUMEX_ENVIRONMENT', 'production'),

    /*
    |--------------------------------------------------------------------------
    | API URLs
    |--------------------------------------------------------------------------
    |
    | Base URLs for the API. You typically don't need to change these unless
    | you're running a self-hosted instance.
    |
    */
    'base_url' => env('RESUMEX_BASE_URL', 'https://api.resumex.com'),
    'sandbox_url' => env('RESUMEX_SANDBOX_URL', 'https://sandbox-api.resumex.com'),

    /*
    |--------------------------------------------------------------------------
    | Editor URL
    |--------------------------------------------------------------------------
    |
    | The URL for the CV editor frontend. Used for generating editor URLs.
    |
    */
    'editor_url' => env('RESUMEX_EDITOR_URL', 'https://app.resumex.com'),

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | Request timeout in seconds
    |
    */
    'timeout' => env('RESUMEX_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Webhook Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for webhook handling
    |
    */
    'webhook' => [
        'secret' => env('RESUMEX_WEBHOOK_SECRET', ''),
        'tolerance' => env('RESUMEX_WEBHOOK_TOLERANCE', 300), // 5 minutes
    ],
];
