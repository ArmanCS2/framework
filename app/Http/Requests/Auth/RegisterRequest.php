<?php

namespace App\Http\Requests\Auth;


use System\Request\Request;

class RegisterRequest extends Request{
    public function rules()
    {
        return [
            'email'=>'required|email|max:64|unique:users,email',
            'password'=>'required|min:8|confirmed',
            'confirm_password'=>'required',
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'avatar'=>'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}