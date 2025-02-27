<?php

namespace App\Http\Requests;

use System\Request\Request;

class CSRFRequest extends Request{
    public function rules()
    {
        return [
            'CSRF' => 'required|validToken',
        ];
    }
}