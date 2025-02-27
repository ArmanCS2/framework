<?php

namespace System\Cookie;

class Cookie{
    public static function set($name,$value){
        setcookie($name,$value,time()+ 86400 * 30);
    }

    public static function get($name){
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
    }

    public static function remove($name){
        if (isset($_COOKIE[$name])){
            setcookie($name,'',time()-1000);
        }
    }

}