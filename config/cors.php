<?php

return [

    'paths' => ['api/*', 'login'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:5174'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
