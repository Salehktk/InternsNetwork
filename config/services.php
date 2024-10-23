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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    


   'google' => [
        'client_id' => env('GOOGLE_WEB_CLIENT_ID'), // default to web
        'client_secret' => env('GOOGLE_WEB_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_WEB_REDIRECT_URI'),
    ],


  'google_app' => [
        'client_id' => env('GOOGLE_APP_CLIENT_ID'),
        'client_secret' => env('GOOGLE_APP_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_APP_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_APP_REDIRECT_URI'),
    
    ],
    
      'facebook-api' => [
        'client_id' => env('FACEBOOK_CLIENT_ID_API'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET_API'),
        'redirect' => env('FACEBOOK_APP_REDIRECT_URI'),
    ],

    
    'apple' => [
    'client_id' => env('APPLE_CLIENT_ID'),
    'client_secret' => env('APPLE_CLIENT_SECRET'),
    'redirect' => env('APPLE_REDIRECT_URI'),
],


    
    'openai' => [
    'key' => env('OPENAI_API_KEY'),
    ],

];
