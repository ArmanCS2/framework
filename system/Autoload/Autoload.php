<?php

namespace System\Autoload;

class Autoload{
    public static function autoload(){
        spl_autoload_register(function ($className){
            $className=str_replace("\\",DIRECTORY_SEPARATOR,$className);
            $path = BASE_PATH . DIRECTORY_SEPARATOR .$className . ".php";
            require_once $path;
        });


    }
}

