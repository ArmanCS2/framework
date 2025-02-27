<?php

namespace App\Http\Requests\Admin;

use System\Request\Request;
use function methodField;

class SlideRequest extends Request{
    public function rules()
    {
        if(methodField()=='put'){
            return [
                'title'=>'required|max:255',
                'body'=>'required',
                'image'=>'file|mimes:jpeg,jpg,png,gif',
                'url'=>'required',
                'address'=>'required|max:255',
                'amount'=>'required|max:255'

            ];
        }

        return [
            'title'=>'required|max:255',
            'body'=>'required',
            'image'=>'required|file|mimes:jpeg,jpg,png,gif',
            'url'=>'required',
            'address'=>'required|max:255',
            'amount'=>'required|max:255'

        ];
    }
}
