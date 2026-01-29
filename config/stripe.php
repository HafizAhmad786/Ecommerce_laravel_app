<?php
// config/services.php (example)
return [
    // ... other services
    'stripe' => [
        'secret' => env('STRIPE_SEC_KEY'),
        'public' => env('STRIPE_KEY'),
    ],
];