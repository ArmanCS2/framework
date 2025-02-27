<?php

namespace App\Http\Controllers\Auth;


use App\Http\Requests\Auth\ResetPasswordRequest;
use App\User;

class ResetPasswordController extends AuthController
{
    public function view($token)
    {
        $user = User::where('remember_token', $token)->get()[0];
        if ($user == null) {
            error('reset_password', 'user not found');
            return redirect($this->redirectToHome);
        }
        if ($user->remember_token_expire < date('Y-m-s H:i:s')) {
            //dd($user->remember_token_expire . " " . date('Y-m-s H:i:s'));
            error('reset_password', 'token is expired');
            return redirect($this->redirectToHome);
        }
        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword($token)
    {
        $user = User::where('remember_token', $token)->get()[0];
        if ($user == null) {
            error('reset_password', 'user not found');
            return back();
        }
        if ($user->remember_token_expire < date('Y-m-s H:i:s')) {
            error('reset_password', 'token is expired');
            return back();
        }
        $request = new ResetPasswordRequest();
        $inputs = $request->all();
        $user->password = hash_password($inputs['password']);
        $user->save();
        return redirect($this->redirectToLogin);
    }
}