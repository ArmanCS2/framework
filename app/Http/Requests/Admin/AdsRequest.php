<?php

namespace App\Http\Requests\Admin;

use System\Request\Request;
use function methodField;

class AdsRequest extends Request
{
    public function rules()
    {
        if(methodField()=='put'){
            return [
                'title'=>'required|max:255',
                'description'=>'required|max:1000',
                'image'=>'file|mimes:jpeg,jpg,png,gif',
                'address'=>'required|max:255',
                'cat_id'=>'required|exist:categories,id',
                'amount'=>'required|max:255',
                'floor'=>'required|max:255',
                'storeroom'=>'required|number',
                'balcony'=>'required|number',
                'room'=>'required|number',
                'parking'=>'required|number',
                'area'=>'required|number',
                'year'=>'required|number',
                'toilet'=>'required|max:255',
                'tag'=>'required|max:255',
                'sell_status'=>'required|number',
                'type'=>'required|number',
            ];
        }

        return [
            'title'=>'required|max:255',
            'description'=>'required|max:1000',
            'image'=>'required|file|mimes:jpeg,jpg,png,gif',
            'address'=>'required|max:255',
            'cat_id'=>'required|exist:categories,id',
            'amount'=>'required|max:255',
            'floor'=>'required|max:255',
            'storeroom'=>'required|number',
            'balcony'=>'required|number',
            'room'=>'required|number',
            'parking'=>'required|number',
            'area'=>'required|number',
            'year'=>'required|number',
            'toilet'=>'required|max:255',
            'tag'=>'required|max:255',
            'sell_status'=>'required|number',
            'type'=>'required|number',
        ];

    }
}