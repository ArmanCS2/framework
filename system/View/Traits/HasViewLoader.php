<?php

namespace System\View\Traits;

use http\Exception;
use System\Config\Config;

trait HasViewLoader{
    private $viewNames=[];
    protected function viewLoader($dir){
        $dir=trim($dir,'. ');
        $dir=str_replace('.',DIRECTORY_SEPARATOR,$dir);
        $path=Config::get('app.BASE_DIR') . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'view' .DIRECTORY_SEPARATOR . $dir . '.blade.php';
        if(file_exists($path)){
            $this->registerView($dir);
            $content=htmlentities(file_get_contents($path));
            return $content;
        }
        else{
            throw new \Exception("$path not found");
        }
    }

    private function registerView($view){
        array_push($this->viewNames,$view);
    }
}