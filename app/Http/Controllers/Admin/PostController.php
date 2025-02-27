<?php


namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\Admin\PostRequest;
use App\Http\Requests\CSRFRequest;
use App\Http\Services\ImageUpload;
use App\Post;
use System\Auth\Auth;
use System\Config\Config;

class PostController extends AdminController
{
    public function index()
    {
        $posts=Post::all();
        return view('admin.post.index',compact('posts'));
    }

    public function create()
    {
        $categories=Category::all();
        return view('admin.post.create',compact('categories'));
    }

    public function store()
    {
        $request=new PostRequest();
        $inputs=$request->all();
        $inputs['user_id']=Auth::user()->id;
        $inputs['status']=0;

        $inputs['image']=ImageUpload::uploadAndFitImage($request->file('image'),path('posts'),name(),800,499);
        //$inputs['image']=ImageUpload::upload($request->file('image'),path('posts'),name());

        //$files=$request->files();
        /*if (is_uploaded_file($files['image']['tmp_name'])){
            move_uploaded_file($files['image']['tmp_name'],Config::get('app.BASE_DIR') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR .
            'images' . DIRECTORY_SEPARATOR . $files['image']['name']);
        }*/

        Post::create($inputs);
        return redirect('admin/post');


    }

    public function edit($id)
    {
        $post=Post::find($id);
        $categories=Category::all();
        return view('admin.post.edit',compact('post','categories'));
    }

    public function update($id)
    {
        $request=new PostRequest();
        $inputs=$request->all();
        $inputs['id']=$id;
        $inputs['user_id']=Auth::user()->id;
        $inputs['status']=0;
        if(!empty($request->file('image')['name'])){
            $inputs['image']=ImageUpload::uploadAndFitImage($request->file('image'),path('posts'),name(),800,499);
            $post=Post::find($id);
            if (file_exists(Config::get('app.BASE_DIR') . '/public' . $post->image)){
                unlink(Config::get('app.BASE_DIR') . '/public' . $post->image);
            }
        }
        Post::update($inputs);
        return redirect('admin/post');
    }

    public function destroy($id)
    {
        $request = new CSRFRequest();
        Post::delete($id);
        return redirect('admin/post');
    }

    public function changeStatus($id){
        $post=Post::find($id);
        if ($post->status==0){
            Post::update(['status'=>1,'id'=>$id]);
        }else{
            Post::update(['status'=>0,'id'=>$id]);
        }
        return redirect('admin/post');
    }
}