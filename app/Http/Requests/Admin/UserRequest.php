<?php

namespace App\Http\Requests\Admin;

use System\Request\Request;

class UserRequest extends Request{
    public function rules()
    {
        return [
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'avatar'=>'file|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
}