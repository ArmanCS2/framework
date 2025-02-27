<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Services\MailService;
use App\User;
use System\Session\Session;

class ForgotController extends AuthController
{
    public function view()
    {
        return view('auth.forgot');
    }

    public function forgot()
    {
        if (Session::get('forgot.time') != false && Session::get('forgot.time') > time()) {
            error('forgot', 'try again after 10 seconds');
            return back();
        } else {
            Session::set('forgot.time', time() + 10);
            $request = new ForgotRequest();
            $inputs = $request->all();
            $user = User::where('email', $inputs['email'])->get()[0];
            if (empty($user)) {
                error('forgot', 'user not found with this email');
                return back();
            }
            $user->remember_token = generateToken();
            $user->remember_token_expire = expire('10 min');
            $user->save();

            $mail = new MailService();
            //$res = $mail->send($user->email, 'بازیابی رمز عبور', forgotMessage($user->remember_token));
            $res = $mail->sendMail($user->email, 'بازیابی رمز عبور', forgotMessage($user->remember_token));
            if ($res) {
                flash('forgot', 'check your emails , email is sent successfully');
                return redirect($this->redirectToHome);
            } else {
                error('forgot', 'an error happened while sending email');
                return back();
            }

        }
    }
}