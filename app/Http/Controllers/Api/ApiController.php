<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use System\Auth\Auth;

class ApiController extends Controller{

    public function __construct()
    {
        $data = json_decode( file_get_contents('php://input') );
        if (!isset($data->token) || !Auth::verifyJWT($data->token)){
            http_response_code(401);
            $response['status']=false;
            $response['message']="token is not valid";
            header('Content-type: application/json');
            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            exit();
        }
    }

}