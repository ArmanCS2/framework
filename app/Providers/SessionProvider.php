<?php

namespace App\Providers;

use System\Config\Config;
use System\Session\Session;

class SessionProvider extends Provider
{
    public function boot()
    {
        session_start();
        //session_regenerate_id(true);
        displayErrors(Config::get('app.DISPLAY_ERROR'));
        if (!isset($_SESSION['CSRF'])){
            Session::set('CSRF',generateToken());
        }
        if (isset($_SESSION['temporary_old'])) {
            unset($_SESSION['temporary_old']);
        }
        if (!empty($_SESSION['old'])) {
            //unset($_SESSION['temporary_old']);
            $_SESSION['temporary_old'] = $_SESSION['old'];
            unset($_SESSION['old']);
        }

        $params = [];
        $params = empty($_GET) ? $params : array_merge($params, $_GET);
        $params = empty($_POST) ? $params : array_merge($params, $_POST);
        $_SESSION['old'] = $params;
        unset($params);

        if (isset($_SESSION['temporary_flash'])) {
            unset($_SESSION['temporary_flash']);
        }
        if (!empty($_SESSION['flash'])) {
            $_SESSION['temporary_flash'] = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        if (isset($_SESSION['temporary_errorFlash'])) {
            unset($_SESSION['temporary_errorFlash']);
        }
        if (!empty($_SESSION['errorFlash'])) {
            $_SESSION['temporary_errorFlash'] = $_SESSION['errorFlash'];
            unset($_SESSION['errorFlash']);
        }
    }
}