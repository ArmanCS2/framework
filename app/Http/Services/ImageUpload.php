<?php

namespace App\Http\Services;

use Intervention\Image\ImageManager;

class ImageUpload{
    public static function uploadAndFitImage($file,$path,$name,$width,$height){
        $path=trim($path,'\/') . '/';
        $name=trim($name,'\/') . '.' . pathinfo($file['name'],PATHINFO_EXTENSION);
        if(!is_dir($path)){
            if(!mkdir($path,0777,true)){
                die('directory not created');
            }
        }
        is_writable($path);
        $manager=new ImageManager(array('driver'=>'gd'));
        $image=$manager->make($file['tmp_name'])->fit($width,$height);
        $image->save($path . $name);
        return '/' . $path . $name;

    }
    public static function upload($file,$path,$name){
        $path=trim($path,'\/') . '/';
        $name=trim($name,'\/') . '.' . pathinfo($file['name'],PATHINFO_EXTENSION);
        if(!is_dir($path)){
            if(!mkdir($path,0777,true)){
                die('directory not created');
            }
        }
        is_writable($path);
        if(is_uploaded_file($file['tmp_name'])){
            if(move_uploaded_file($file['tmp_name'],$path . $name)){
                return '/' . $path . $name;
            }

        }

        error('image','failed to upload image');
        return back();




    }
}
