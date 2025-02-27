<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SlideRequest;
use App\Http\Requests\CSRFRequest;
use App\Http\Services\ImageUpload;
use App\Slide;

class SlideController extends AdminController{
    public function index()
    {
        $slides=Slide::all();
        return view('admin.slide.index',compact('slides'));
    }
    public function create()
    {
        return view('admin.slide.create');
    }
    public function store()
    {
        $request=new SlideRequest();
        $inputs=$request->all();
        $file=$request->file('image');
        $inputs['image']=ImageUpload::uploadAndFitImage($file,path('slides'),name(),1500,904);
        Slide::create($inputs);
        return redirect('admin/slide');
    }
    public function edit($id)
    {
        $slide=Slide::find($id);
        return view('admin.slide.edit',compact('slide'));
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
        $request = new CSRFRequest();
        Slide::delete($id);
        return redirect('admin/slide');
    }
}