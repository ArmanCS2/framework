<?php

namespace App\Http\Requests\Admin;

use System\Request\Request;

class CategoryRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'parent_id' => 'exists:categories,id'
        ];
    }
}