<?php

namespace App\Http\Controllers;

use App\Ads;
use App\Category;
use App\Comment;
use App\Http\Requests\App\CommentRequest;
use App\Http\Services\MeliPayamakService;
use App\Post;
use App\Slide;
use System\Auth\Auth;
use System\Database\DBConnection\DataBase;

class HomeController extends Controller{
    public function index(){
        $slides=Slide::all();
        $recentAds=Ads::orderBy('created_at','DESC')->limit(0,6)->get();
        $bestAds=Ads::orderBy('view','DESC')->orderBy('created_at','DESC')->limit(0,4)->get();
        $posts=Post::where('published_at','<=',date('Y-m-d H:i:s'))->orderBy('created_at','DESC')->limit(0,4)->get();
        return view('app.index',compact('slides','recentAds','bestAds','posts'));
    }
    public function about(){
        return view('app.about');
    }

    public function ad($id){
        $ad=Ads::find($id);

        $galleries=$ad->galleries()->get();

        $categories=Category::all();

        $posts=Post::where('published_at','<=',date('Y-m-d H:i:s'))->orderBy('created_at','DESC')->limit(0,4)->get();

        $relatedAds=Ads::where('cat_id',$ad->cat_id)->where('id','!=',$id)->orderBy('created_at','DESC')->limit(0,2)->get();

        return view('app.ad',compact('ad','categories','posts','relatedAds','galleries'));
    }

    public function ads(){
        $ads=Ads::all();
        return view('app.ads',compact('ads'));
    }

    public function post($id){
        $post=Post::find($id);
        $comments=Comment::where('approved',1)->where('post_id',$id)->whereNull('parent_id')->get();
        $posts=Post::where('published_at','<=',date('Y-m-d H:i:s'))->orderBy('created_at','DESC')->limit(0,4)->get();
        $categories=Category::all();
        return view('app.post',compact('post','categories','posts','comments'));
    }
    public function posts(){
        $posts=Post::all();
        return view('app.posts',compact('posts'));
    }

    public function postComment($id){
        $request= new CommentRequest();
        $inputs=$request->all();
        $inputs['status']=0;
        $inputs['approved']=0;
        $inputs['post_id']=$id;
        $inputs['user_id']=Auth::user()->id;
        Comment::create($inputs);
        return back();
    }

    public function category($id){
        $category=Category::find($id);
        $posts=$category->posts()->get();
        $ads=$category->ads()->get();
        return view('app.category',compact('category','posts','ads'));
    }

    public function search(){
        if(isset($_GET['search']) && !empty(trim($_GET['search'],' '))){
            $search='%'.$_GET['search'].'%';
            $ads=Ads::whereOr('tag','LIKE',$search)->where('title','LIKE',$search)->get();
            $posts=Post::where('title','LIKE',$search)->get();
            return view('app.search',compact('ads','posts'));
        }else{
            return back();
        }
    }
    public function ajaxLastPosts(){
        $posts=Post::where('published_at','<=',date('Y-m-d H:i:s'))->orderBy('created_at','DESC')->limit(0,4)->get();
        foreach ($posts as $post){
            $post->username=$post->user()->first_name . " " . $post->user()->last_name;
            $post->image=asset($post->image);
            unset($post->user_id);
            $post->created_at=jalaliDate($post->created_at);
            $post->url=route('post',[$post->id]);
            $post->comment_count=count($post->comments()->get());
        }
        header('Content-type: application/json');
        $result=json_encode($posts,JSON_UNESCAPED_UNICODE);
        echo $result;
        exit();
    }
}