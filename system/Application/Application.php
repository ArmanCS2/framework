<?php

namespace System\Application;

class Application
{
    public function __construct()
    {
        $this->loadHelpers();
        $this->loadProviders();
        $this->registerRoutes();
        $this->routing();

    }

    private function loadProviders()
    {
        $appConfig = require_once dirname(dirname(__DIR__)) . "/config/app.php";
        $providers = $appConfig['providers'];
        foreach ($providers as $provider) {
            $providerObj = new $provider();
            $providerObj->boot();
        }
    }

    private function loadHelpers()
    {
        require_once dirname(__DIR__) . "/Helpers/helpers.php";
        if (file_exists(dirname(dirname(__DIR__)) . "/app/Http/Helpers.php")) {
            require_once dirname(dirname(__DIR__)) . "/app/Http/Helpers.php";
        }
    }

    private function registerRoutes()
    {
        global $routes;
        $routes = [
            'get' => [],
            'post' => [],
            'put' => [],
            'delete' => []
        ];
        require_once dirname(dirname(__DIR__)) ."/routes/api.php";
        require_once dirname(dirname(__DIR__)) ."/routes/web.php";
    }

    private function routing()
    {
        $routing = new \System\Router\Routing();
        $routing->run();
    }
}