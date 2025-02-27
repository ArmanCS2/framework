<?php

namespace App\Http\Requests\Auth;

use System\Request\Request;

class ForgotRequest extends Request{
    public function rules()
    {
        return [
            'email'=>'required|email|max:64|exist:users,email'
        ];
    }
}