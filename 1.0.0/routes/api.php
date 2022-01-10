<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->post('/weapp/code','App\Http\Controllers\Api\Auth\WeAppUserLoginController@code');
    $api->post('/weapp/login','App\Http\Controllers\Api\Auth\WeAppUserLoginController@login');

    $api->get('/','App\Http\Controllers\Api\HomeController@index');
    $api->post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
    $api->post('register', 'App\Http\Controllers\Api\Auth\RegisterController@register');

    $api->post('/qrcodes/generate','App\Http\Controllers\Api\QrCodeController@generateQrCode');
    $api->get('/qrcodes','App\Http\Controllers\Api\QrCodeController@getQrCodes');
    $api->delete('/qrcodes/{id}','App\Http\Controllers\Api\QrCodeController@destroy');
    
    $api->get('/banners','App\Http\Controllers\Api\HomeController@getBanners');
    $api->get('/pages','App\Http\Controllers\Api\PageController@getPages');
    $api->get('/pages/{id}','App\Http\Controllers\Api\PageController@getPage');
    $api->get('/pages/slug/{slug}','App\Http\Controllers\Api\PageController@getPageSlug');
    $api->get('/page-categories','App\Http\Controllers\Api\PageCategoryController@getPageCategories');

    $api->get('/page-recruits','App\Http\Controllers\Api\PageController@getRecruits');
    $api->get('/page-contact','App\Http\Controllers\Api\PageController@getContacts');
    $api->get('/banners','App\Http\Controllers\Api\HomeController@getBanners');
    $api->get('/links','App\Http\Controllers\Api\LinkController@getLinks');
    $api->get('/navs','App\Http\Controllers\Api\NavController@getNavs');
    $api->post('test','App\Http\Controllers\Api\HomeController@test');

    $api->get('/videoVid','App\Http\Controllers\Api\HomeController@getVideoVid');
    $api->get('/message','App\Http\Controllers\Api\MessageController@getMessages');
    $api->post('/message','App\Http\Controllers\Api\MessageController@storeMessage');
});
