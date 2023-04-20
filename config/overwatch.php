<?php

// config for Modernmcguire/Overwatch
return [
    'metrics' => [
        StripeDataController::class,
    ],
    'services' => [
        'stripe' => [
            'secret' => env('STRIPE_SECRET', Secrets::$stripePrivateKey),
        ],
    ],
];
