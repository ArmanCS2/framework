<?php


namespace App\Http\Requests\Admin;

use System\Request\Request;
use function methodField;

class PostRequest extends Request{
    public function rules()
    {
        if(methodField()=='put'){
            return [
                'title'=>'required|max:255',
                'body'=>'required',
                'image'=>'file|mimes:jpeg,jpg,png,gif',
                'cat_id'=>'required|exist:categories,id',
                'published_at'=>'required|date'

            ];
        }

        return [
            'title'=>'required|max:255',
            'body'=>'required',
            'image'=>'required|file|mimes:jpeg,jpg,png,gif',
            'cat_id'=>'required|exist:categories,id',
            'published_at'=>'required|date'

        ];

    }
}
