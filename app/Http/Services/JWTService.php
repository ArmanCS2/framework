<?php

namespace App\Http\Services;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService{
    private static $secretKey='arman';
    public static function create($data=null){
        $payload=[
            'iss'=>'https://armanafzali.ir',
            'iat'=>time(),
            'nbf'=>time()+20,
            'exp'=>time()+3*24*3600,
            'data'=>$data
        ];
        $jsonWebToken=JWT::encode($payload,self::$secretKey,'HS256');
        if ($jsonWebToken){
            return $jsonWebToken;
        }else{
            return false;
        }
    }
    public static function isVerified($jwt){
        try {
            $payload=JWT::decode($jwt,new Key(self::$secretKey,'HS256'));
            return $payload;
        }catch (\Exception $e){
            return false;
        }


    }

}