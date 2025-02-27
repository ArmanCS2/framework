<?php


use \System\Router\Api\Route;

//Api
Route::get('ads','Api\AdsController@all');
Route::post('ads/store','Api\AdsController@store');
Route::put('ads/update/{id}','Api\AdsController@update');
Route::delete('ads/delete/{id}','Api\AdsController@delete');


Route::post('register','Api\Auth\AuthController@register');
Route::post('login','Api\Auth\AuthController@login');






