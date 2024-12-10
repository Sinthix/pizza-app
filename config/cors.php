<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Specify paths to apply CORS
    'allowed_methods' => ['*'],                 // Allow all HTTP methods
    'allowed_origins' => ['http://localhost:5173'], // Add your frontend URL
    'allowed_origins_patterns' => [],           // Leave empty
    'allowed_headers' => ['*'],                 // Allow all headers
    'exposed_headers' => [],                    // Leave empty unless needed
    'max_age' => 0,                             // Leave as 0
    'supports_credentials' => true,             // Enable for Sanctum or cookies
];