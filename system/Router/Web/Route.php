<?php
 namespace System\Router\Web;

 class Route{
     public static function get($url,$executeMethod,$name=null){
         $executeMethod=explode('@',$executeMethod);
         $class=$executeMethod[0];
         $method=$executeMethod[1];
         global $routes;
         array_push($routes['get'],['url'=>$url,'class'=>$class,'method'=>$method, 'name' => $name]);
     }
     public static function post($url,$executeMethod,$name=null){
         $executeMethod=explode('@',$executeMethod);
         $class=$executeMethod[0];
         $method=$executeMethod[1];
         global $routes;
         array_push($routes['post'],['url'=>$url,'class'=>$class,'method'=>$method,'name'=>$name]);
     }
     public static function put($url,$executeMethod,$name=null){
         $executeMethod=explode('@',$executeMethod);
         $class=$executeMethod[0];
         $method=$executeMethod[1];
         global $routes;
         array_push($routes['put'],['url'=>$url,'class'=>$class,'method'=>$method,'name'=>$name]);
     }
     public static function delete($url,$executeMethod,$name=null){
         $executeMethod=explode('@',$executeMethod);
         $class=$executeMethod[0];
         $method=$executeMethod[1];
         global $routes;
         array_push($routes['delete'],['url'=>$url,'class'=>$class,'method'=>$method,'name'=>$name]);
     }
 }