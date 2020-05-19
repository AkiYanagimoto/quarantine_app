<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth']], function () {
    // api関連の処理をまとめる（urlに自動的に/apiが加わる）
    Route::group(['middleware' => ['api']], function () {

        // 表示
        Route::get('/', 'Api\ProfileController@index');
        // 更新
        //Route::post('/profile/{id}/profile', 'Api\ProfileController@update');
        Route::put('profile/{id}', 'ProfileController@update');
        // 登録
        Route::post('/profiles', 'Api\ProfileController@');
        // 削除
        //Route::post('/profile/{profile}', 'Api\ProfileController@destroy');
    });
});
