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

Route::group([
    'namespace'=>'App\User'
], function () {
    Route::post('login', 'Controller\AuthController@login');
    Route::post('register', 'Controller\AuthController@register');

    Route::group([
        'middleware' => 'auth:api'
      ], function() {
          Route::get('user', 'Controller\AuthController@getAuthUser');
       
          
          
          Route::get('logout', 'Controller\AuthController@logout');
      });
  });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
