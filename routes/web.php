<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix'=>'products'],function($app){
  $app->get('/','v1\ProductsController@index');
  $app->get('/{id}','v1\ProductsController@show');
});

$app->group(['prefix'=>'admin'],function ($app){
  $app->post('/login','v1\AdminsController@login');
});

//..........all admin work..........
//.........product area
$app->group(['middleware'=>'auth','prefix'=>'admin/products'],function($app){
  $app->post('/','v1\ProductsController@store');
  $app->put('/{id}','v1\ProductsController@update');
  $app->delete('/{id}','v1\ProductsController@destroy');
});

//.........category area
$app->group(['middleware'=>'auth','prefix'=>'admin/category'],function($app){
  $app->get('/','v1\CategoryController@index');
  $app->post('/','v1\CategoryController@store');
  $app->put('/{id}','v1\CategoryController@update');
  $app->delete('/{id}','v1\CategoryController@destroy');
});
