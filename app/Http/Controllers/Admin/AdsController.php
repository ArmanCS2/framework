<?php

namespace App\Http\Controllers\Admin;

use App\Ads;
use App\Category;
use App\Gallery;
use App\Http\Requests\Admin\AdsRequest;
use App\Http\Requests\Admin\GalleryRequest;
use App\Http\Requests\CSRFRequest;
use App\Http\Services\ImageUpload;
use System\Auth\Auth;

class AdsController extends AdminController
{
    public function index()
    {
        $ads=Ads::all();
        return view('admin.ads.index',compact('ads'));
    }

    public function create()
    {
        $categories=Category::all();
        return view('admin.ads.create',compact('categories'));
    }

    public function store()
    {
        $request= new AdsRequest();
        $inputs=$request->all();
        $inputs['user_id']=Auth::user()->id;
        $inputs['status']=0;
        $inputs['view']=0;
        $inputs['image']=ImageUpload::uploadAndFitImage($request->file('image'),path('ads'),name(),800,532);
        Ads::create($inputs);
        return redirect('admin/ads');
    }

    public function edit($id)
    {
        $categories=Category::all();
        $ad=Ads::find($id);
        return view('admin.ads.edit',compact('categories','ad'));
    }

    public function update($id)
    {
        $request= new AdsRequest();
        $inputs=$request->all();
        $inputs['id']=$id;
        $inputs['user_id']=Auth::user()->id;
        $inputs['status']=0;
        $inputs['view']=0;
        if (!empty($request->file('image')['name'])) {
            $inputs['image'] = ImageUpload::uploadAndFitImage($request->file('image'), path('ads'), name(), 800, 532);
        }
        Ads::update($inputs);
        return redirect('admin/ads');
    }

    public function destroy($id)
    {
        $request = new CSRFRequest();
        Ads::delete($id);
        return redirect('admin/ads');
    }
    public function gallery($id){
        $ad=Ads::find($id);
        $galleries=Gallery::where('advertise_id',$id)->get();
        return view('admin.ads.gallery',compact('ad','galleries'));
    }
    public function storeGalleryImage($id){
        $request=new GalleryRequest();

        $file=$request->file('image');

        $inputs['image']=ImageUpload::uploadAndFitImage($file,path('galleries'),name(),730,400);
        $inputs['advertise_id']=$id;

        Gallery::create($inputs);
        return back();

    }
    public function deleteGalleryImage($id){
        //$gallery_advertise_id=Gallery::find($id)->advertise_id;
        Gallery::delete($id);
        return back();
    }
}
