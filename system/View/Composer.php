<?php

namespace System\View;

class Composer
{
    private static $instance;
    private $vars = [];
    private $views=[];
    private $registeredViews=[];

    private function __construct()
    {
    }

    public static function __callStatic($method, $args)
    {
        $obj = self::getInstance();
        switch ($method) {
            case "view":
                return call_user_func_array(array($obj, "registerView"), $args);
                break;
            case "setViews":
                return call_user_func_array(array($obj, "setViewsMethod"), $args);
                break;
            case "getVars":
                return call_user_func_array(array($obj, "getviewVars"), $args);
                break;
        }

    }

    private function registerView($name, $callback)
    {
        $this->registeredViews[$name]=$callback;
    }

    private static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function setViewsMethod($views)
    {
        $this->views = $views;
    }

    private function getviewVars()
    {
        foreach ($this->views as $view){
            if (isset($this->registeredViews[str_replace(DIRECTORY_SEPARATOR,'.',$view)])){
                $callback=$this->registeredViews[str_replace(DIRECTORY_SEPARATOR,'.',$view)];
                $viewVars=$callback();
                foreach ($viewVars as $key => $value){
                    $this->vars[$key]=$value;
                }
            }
        }
        return $this->vars;
    }
}
