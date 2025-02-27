<?php

namespace App\Http\Controllers;

class Controller{
    public $redirectToLogin='login';
    public $redirectToHome='home';
    public $redirectToAdmin='admin';
    public $redirectToRegister='register';
    public function __construct()
    {
    }
}