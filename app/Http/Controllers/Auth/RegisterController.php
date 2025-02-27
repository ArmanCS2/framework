<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\ImageUpload;
use App\Http\Services\MailService;
use App\User;

class RegisterController extends AuthController{

    public function view(){
        return view('auth.register');
    }

    public function register(){
        $request=new RegisterRequest();
        $inputs=$request->all();
        $inputs['avatar']=ImageUpload::uploadAndFitImage($request->file('avatar'),path('avatars'),name(),100,100);
        $inputs['verify_token']=generateToken();
        $inputs['is_active']=0;
        $inputs['user_type']='user';
        $inputs['status']=0;
        $inputs['remember_token']=null;
        $inputs['remember_token_expire']=null;
        $inputs['password']=password_hash($inputs['password'],PASSWORD_DEFAULT);

        $mail=new MailService();
        $res=$mail->send($inputs['email'],'فعال سازی حساب کاربری',activationMessage($inputs['verify_token']));
        if ($res){
            User::create($inputs);
        }
        return redirect($this->redirectToLogin);
    }

    public function activation($token){
        $user=User::where('verify_token',$token)->get()[0];
        if (!empty($user)){
            if ($token==$user->verify_token){
                User::update(['is_active'=>1,'id'=>$user->id]);
                return redirect($this->redirectToLogin);
            }
        }
        return redirect($this->redirectToHome);
    }
}