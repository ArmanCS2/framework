<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Admin\SlideRequest;
use App\Http\Services\ImageUpload;
use App\Slide;

class SlideController extends ApiController{

    public function store()
    {
        $request=new SlideRequest();
        $inputs=$request->all();
        $file=$request->file('image');
        $inputs['image']=ImageUpload::uploadAndFitImage($file,path('slides'),name(),1500,904);
        Slide::create($inputs);
        return redirect('admin/slide');
    }

    public function update($id)
    {
        $request=new SlideRequest();
        $inputs=$request->all();
        $inputs['id']=$id;
        $file=$request->file('image');
        if(!empty($file['tmp_name'])) {
            $inputs['image'] = ImageUpload::uploadAndFitImage($file, path('slides'), name(), 1500, 904);
        }
        Slide::update($inputs);
        return redirect('admin/slide');
    }
    public function destroy($id)
    {
        Slide::delete($id);
        return redirect('admin/slide');
    }
}