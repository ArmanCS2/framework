<?php



return [
    'APP_TITLE' => 'My Framework',
    'BASE_DIR' => realpath(__DIR__ . "/../"),
    'BASE_URL' => currentDomain(),
    'DISPLAY_ERROR'=>true,
    'providers'=>[
        \App\Providers\AppServiceProvider::class,
        \App\Providers\SessionProvider::class,
    ]
];


