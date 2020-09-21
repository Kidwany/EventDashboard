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
    'firebase' => [
        'api_key' => 'AIzaSyAg7YldT4tfQkYNZ6p3gCN2fTKqlIO',
        'auth_domain' => 'hemmtk.firebaseapp.com',
        'database_url' => 'https://hemmtk.firebaseio.com',
        'project_id' => 'hemmtk',
        'storage_bucket' => 'hemmtk.appspot.com',
        'messaging_sender_id' => '812248925986',
        'app_id' => '1:812248925986:web:3ec6b0269e8ea87ad8477b',
        'measurement_id' => 'G-1L01CPZ2LD',
    ],

];
