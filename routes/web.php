<?php

use Illuminate\Support\Facades\Route;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/test', function () {
//     return view('index');
// });

// トップ画面
Route::get('/', function () {

    // アカウントの登録総数
    $total_user = User::all();
    $count_user = count($total_user);

    return view('index', [
        'count_user' => $count_user,
    ]);
});


Auth::routes();

Route::get('/location', 'HomeController@index')->name('location');

Route::resource('/home', 'HomeController');

Route::resource('/profile', 'ProfileController');


Route::get('/api_ajax', 'ProfileController@api_ajax');
