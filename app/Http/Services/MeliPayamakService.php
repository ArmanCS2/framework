<?php

namespace App\Http\Services;

use Melipayamak\MelipayamakApi;

class MeliPayamakService
{
    private $api;
    private $username = '09223618018';
    private $password = 'ML8Z9';
    private $from = '50004001618018';

    public function __construct()
    {
        $this->api = new MelipayamakApi($this->username, $this->password);
    }


    public function send($to, $text, $isFlash = true)
    {
        try {
            $sms = $this->api->sms();
            $response = $sms->send($to, $this->from, $text);
            $json = json_decode($response);
            return $json->Value; //RecId or Error Number
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
