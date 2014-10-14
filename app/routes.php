<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('login1', function(){
	return View::make('login1');
});
Route::get('login', array('uses' => 'CommonController@login'));

Route::get('test1', array('uses' => 'CommonController@test1'));
Route::get('test2', array('uses' => 'CommonController@test2'));

//获取验证码
Route::get('renderCaptcha', array('uses' => 'CommonController@renderCaptcha'));
//ajax验证验证码
Route::post('validateCaptcha', array('uses' => 'CommonController@validateCaptcha'));

Route::post('dealLogin', array('before' => 'csrf','uses' => 'CommonController@dealLogin'));

Route::get('dealLoginOut', array('uses' => 'CommonController@dealLoginOut'));

Route::controller("user", "UserController");

Route::controller("role", "RoleController");

Route::controller("taxonomy", "TaxonomyController");

Route::controller("news", "NewsController");

Route::controller("partner", "PartnerController");

Route::controller("branch", "BranchController");

Route::controller("career", "CareerController");

Route::controller("product", "ProductController");

Route::controller("customer", "CustomerController");

Route::controller("download", "DownloadController");
