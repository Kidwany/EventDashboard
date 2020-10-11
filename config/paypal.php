<?php


return [
    // Sandbox
    'sandbox_client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
    'sandbox_secret' => env('PAYPAL_SANDBOX_SECRET'),

    // Live
    'live_client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
    'live_secret' => env('PAYPAL_LIVE_SECRET'),

    'settings' => [
        // Mode: Live or Secret
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        // Connection Timeout
        'http.ConnectionTimeOut' => 3000,
        //Logs
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        //Level
        'log.LogLevel' => 'DEBUG'
    ]
];
