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

Route::get('products', 'api\ProductController@products');
Route::get('categories', 'api\ProductController@categories');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'api\AuthController@login');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {

        Route::post('signup', 'api\AuthController@signup');
        Route::get('logout', 'api\AuthController@logout');
        Route::get('user', 'api\AuthController@user');

    });
});