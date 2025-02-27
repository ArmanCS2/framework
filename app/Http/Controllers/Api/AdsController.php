<?php

namespace App\Http\Controllers\Api;

use App\Ads;
use App\Category;
use App\Gallery;
use App\Http\Requests\Admin\AdsRequest;
use App\Http\Requests\Admin\GalleryRequest;
use App\Http\Services\ImageUpload;
use System\Auth\Auth;

class AdsController extends ApiController
{

    public function all(){
        $ads=Ads::all();
        header('Content-type: application/json');
        $result=json_encode($ads,JSON_UNESCAPED_UNICODE);
        echo $result;
        exit();
    }

    public function store()
    {
        $data = json_decode( file_get_contents('php://input') );
        dd('store');
    }


    public function update($id)
    {
        $data = json_decode( file_get_contents('php://input') );
        dd('update');
    }

    public function delete($id)
    {
        $data = json_decode( file_get_contents('php://input') );
        dd('delete');
    }

}
