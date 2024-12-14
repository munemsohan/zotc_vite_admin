<?php

return [
    'paths' => ['api/*'],  // Adjust as needed
    'allowed_methods' => ['*'],
    'allowed_origins' =>  ['http://localhost:3000'], // Allow all origins
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];




