<?php


use \System\Router\Web\Route;


//Home
Route::get('/', 'HomeController@index', 'index');
Route::get('home', 'HomeController@index', 'index');
Route::get('about', 'HomeController@about', 'about');
Route::get('ad/{id}', 'HomeController@ad', 'ad');
Route::get('ads', 'HomeController@ads', 'ads');
Route::get('post/{id}', 'HomeController@post', 'post');
Route::get('posts', 'HomeController@posts', 'posts');
Route::post('post/comment/{id}', 'HomeController@postComment', 'post.comment');
Route::get('category/{id}', 'HomeController@category', 'category');
Route::get('search', 'HomeController@search', 'search');

//Ajax
Route::get('ajax-last-posts', 'HomeController@ajaxLastPosts', 'ajax.last.posts');


//Admin
Route::get('admin', 'Admin\AdminController@index', 'admin.index');

Route::get('admin/category', 'Admin\CategoryController@index', 'admin.category.index');
Route::get('admin/category/create', 'Admin\CategoryController@create', 'admin.category.create');
Route::post('admin/category/store', 'Admin\CategoryController@store', 'admin.category.store');
Route::get('admin/category/edit/{id}', 'Admin\CategoryController@edit', 'admin.category.edit');
Route::put('admin/category/update/{id}', 'Admin\CategoryController@update', 'admin.category.update');
Route::delete('admin/category/delete/{id}', 'Admin\CategoryController@destroy', 'admin.category.delete');

Route::get('admin/post', 'Admin\PostController@index', 'admin.post.index');
Route::get('admin/post/create', 'Admin\PostController@create', 'admin.post.create');
Route::post('admin/post/store', 'Admin\PostController@store', 'admin.post.store');
Route::get('admin/post/edit/{id}', 'Admin\PostController@edit', 'admin.post.edit');
Route::put('admin/post/update/{id}', 'Admin\PostController@update', 'admin.post.update');
Route::delete('admin/post/delete/{id}', 'Admin\PostController@destroy', 'admin.post.delete');
Route::get('admin/post/change-status/{id}', 'Admin\PostController@changeStatus', 'admin.post.change.status');

Route::get('admin/ads', 'Admin\AdsController@index', 'admin.ads.index');
Route::get('admin/ads/create', 'Admin\AdsController@create', 'admin.ads.create');
Route::post('admin/ads/store', 'Admin\AdsController@store', 'admin.ads.store');
Route::get('admin/ads/edit/{id}', 'Admin\AdsController@edit', 'admin.ads.edit');
Route::put('admin/ads/update/{id}', 'Admin\AdsController@update', 'admin.ads.update');
Route::delete('admin/ads/delete/{id}', 'Admin\AdsController@destroy', 'admin.ads.delete');
Route::get('admin/ads/gallery/{id}', 'Admin\AdsController@gallery', 'admin.ads.gallery');
Route::post('admin/ads/store-galley-image/{id}', 'Admin\AdsController@storeGalleryImage', 'admin.ads.store.gallery.image');
Route::get('admin/ads/delete-galley-image/{id}', 'Admin\AdsController@deleteGalleryImage', 'admin.ads.delete.gallery.image');

Route::get('admin/slide', 'Admin\SlideController@index', 'admin.slide.index');
Route::get('admin/slide/create', 'Admin\SlideController@create', 'admin.slide.create');
Route::post('admin/slide/store', 'Admin\SlideController@store', 'admin.slide.store');
Route::get('admin/slide/edit/{id}', 'Admin\SlideController@edit', 'admin.slide.edit');
Route::put('admin/ads/slide/{id}', 'Admin\SlideController@update', 'admin.slide.update');
Route::delete('admin/slide/delete/{id}', 'Admin\SlideController@destroy', 'admin.slide.delete');

Route::get('admin/comment', 'Admin\CommentController@index', 'admin.comment.index');
Route::get('admin/comment/show/{id}', 'Admin\CommentController@show', 'admin.comment.show');
Route::get('admin/comment/approve/{id}', 'Admin\CommentController@approve', 'admin.comment.approve');
Route::post('admin/comment/reply/{id}', 'Admin\CommentController@reply', 'admin.comment.reply');
Route::get('admin/comment/delete/{id}', 'Admin\CommentController@destroy', 'admin.comment.delete');

Route::get('admin/user', 'Admin\UserController@index', 'admin.user.index');
Route::get('admin/user/edit/{id}', 'Admin\UserController@edit', 'admin.user.edit');
Route::put('admin/user/update/{id}', 'Admin\UserController@update', 'admin.user.update');
Route::get('admin/user/change-status/{id}', 'Admin\UserController@changeStatus', 'admin.user.change.status');

//Auth
Route::get('register', 'Auth\RegisterController@view', 'auth.register.view');
Route::post('register', 'Auth\RegisterController@register', 'auth.register');
Route::get('activation/token/{token}', 'Auth\RegisterController@activation', 'auth.activation.token');

Route::get('login', 'Auth\LoginController@view', 'auth.login.view');
Route::post('login', 'Auth\LoginController@login', 'auth.login');

Route::get('logout', 'Auth\LogoutController@logout', 'auth.logout');

Route::get('forgot', 'Auth\ForgotController@view', 'auth.forgot.view');
Route::post('forgot', 'Auth\ForgotController@forgot', 'auth.forgot');

Route::get('reset-password/{token}', 'Auth\ResetPasswordController@view', 'auth.reset.password.view');
Route::post('reset-password/{token}', 'Auth\ResetPasswordController@resetPassword', 'auth.reset.password');