<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . "/vendor/autoload.php";

//require_once BASE_PATH . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'Autoload' . DIRECTORY_SEPARATOR . 'Autoload.php';
//\System\Autoload\Autoload::autoload();

new \System\Application\Application();

//new \System\Database\DBBuilder\DBBuilder();