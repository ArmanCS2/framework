<?php

namespace System\Auth;

use App\Http\Services\JWTService;
use System\Session\Session;
use System\Cookie\Cookie;
use App\User;

class Auth
{
    private $redirectTo = 'login';

    private function userMethod()
    {
        if (!Session::get('user') && !Cookie::get('user')) {
            return redirect($this->redirectTo);
        }
        if(Cookie::get('user')){
            $user = User::find(Cookie::get('user'));
            if (empty($user)) {
                Cookie::remove('user');
                return redirect($this->redirectTo);
            }

        }
        if(Session::get('user')){
            $user = User::find(Session::get('user'));
            if (empty($user)) {
                Session::remove('user');
                return redirect($this->redirectTo);
            }

        }

        return $user;

    }

    private function checkMethod()
    {

        if (!Session::get('user') && !Cookie::get('user')) {
            return redirect($this->redirectTo);
        }
        if(Cookie::get('user')){
            $user = User::find(Cookie::get('user'));
            if (empty($user)) {
                Cookie::remove('user');
                return redirect($this->redirectTo);
            }

        }
        if(Session::get('user')){
            $user = User::find(Session::get('user'));
            if (empty($user)) {
                Session::remove('user');
                return redirect($this->redirectTo);
            }

        }
        return true;
    }

    private function checkLoginMethod()
    {
        if (!Session::get('user') && !Cookie::get('user')) {
            return false;
        }
        if(Cookie::get('user')){
            $user = User::find(Cookie::get('user'));
            if (empty($user)) {
                Cookie::remove('user');
                return false;
            }

        }
        if(Session::get('user')){
            $user = User::find(Session::get('user'));
            if (empty($user)) {
                Session::remove('user');
                return false;
            }

        }
        return true;
    }

    private function loginByEmailMethod($email, $password)
    {
        $user = User::where('email', $email)->get();
        if (!empty($user)) {
            $user = User::where('email', $email)->get()[0];
            if ($user->is_active == 1) {
                if (password_verify($password, $user->password)) {
                    Session::set('user', $user->id);
                    Cookie::set('user', $user->id);
                    return true;
                } else {
                    error('login', 'پسورد اشتباه است');
                    return false;
                }
            } else {
                error('login', 'کاربر فعال نمیباشد');
                return false;
            }

        } else {
            error('login', 'کاربر یافت نشد');
            return false;
        }
    }

    private function verifyJWTMethod($jwt){
        $payload=JWTService::isVerified($jwt);
        if ($payload){
            return $payload;
        }else{
            return false;
        }
    }

    private function apiLoginByEmailMethod($email, $password)
    {
        $user = User::where('email', $email)->get();
        if (!empty($user)) {
            $user = User::where('email', $email)->get()[0];
            if ($user->is_active == 1) {
                if (password_verify($password, $user->password)) {
                    $jwt=JWTService::create(['email'=>$email]);
                    $user->jwt=$jwt;
                    $user->save();
                    return $jwt;
                } else {
                    error('login', 'پسورد اشتباه است');
                    return false;
                }
            } else {
                error('login', 'کاربر فعال نمیباشد');
                return false;
            }

        } else {
            error('login', 'کاربر یافت نشد');
            return false;
        }
    }

    private function loginByIdMethod($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            Session::set('user', $user->id);
            Cookie::set('user', $user->id);
            return true;
        } else {
            error('login', 'کاربر یافت نشد');
            return false;
        }
    }

    private function logoutMethod()
    {
        Session::remove('user');
        Cookie::remove('user');
    }

    public
    function __call($method, $args)
    {
        return $this->methodCaller($method, $args);
    }

    public static
    function __callStatic($method, $args)
    {
        $obj = new self();
        return $obj->methodCaller($method, $args);
    }

    private
    function methodCaller($method, $args)
    {
        $methodName = $method . "Method";
        return call_user_func_array(array($this, $methodName), $args);
    }
}