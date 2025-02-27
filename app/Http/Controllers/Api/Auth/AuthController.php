<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use System\Auth\Auth;

class AuthController {
    public function register(){
        $data = json_decode( file_get_contents('php://input') );
        $response['status']=false;
        $response['message']="failed";
        http_response_code(200);
        header('Content-type: application/json');
        echo json_encode($response,JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function login()
    {
        $data = json_decode( file_get_contents('php://input') );
        $jwt=Auth::apiLoginByEmail($data->email, $data->password);
        if ($jwt) {
            $user = User::where('email', $data->email)->get()[0];
            if ($user->user_type == 'admin') {
                http_response_code(200);
                $response['status']=true;
                $response['message']="login successfully for admin";
                $response['token']=$jwt;
            } else {
                http_response_code(200);
                $response['status']=true;
                $response['message']="login successfully for user";
                $response['token']=$jwt;
            }
        }else{
            http_response_code(401);
            $response['status']=false;
            $response['message']="login failed";
            $response['token']=null;
        }
        header('Content-type: application/json');
        echo json_encode($response,JSON_UNESCAPED_UNICODE);
        exit();
    }
}