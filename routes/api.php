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

// Route::post('login', 'Auth\LoginController@login');
// Route::get('getAllData', 'Auth\LoginController@getAllData');

Route::prefix('admin')->group(function(){
    // login
    // user authentication
    // Route::get('/', 'PengelolaController@index');
    // Route::get('login', 'PengelolaController@login');
    Route::post('loginpost', 'PengelolaController@loginpost');
    Route::get('logout', 'PengelolaController@logout');

    // cek email admin
    Route::post('cekEmail', 'AdminController@cekemail');
    Route::post('cekemail_teknisi', 'TeknisiController@cekemail');
    Route::post('ceknamaproject', 'ProjectController@ceknamaproject');

    // api admin
    Route::post('tambahTS', 'AdminController@store');
    Route::post('updatedataTS', 'AdminController@updatedata');
    Route::get('hapusdataTS/{id}', 'AdminController@destroy');

    // api teknisi
    Route::post('tambahTeknisi', 'TeknisiController@store');
    Route::post('updatedataTeknisi', 'TeknisiController@updatedata');
    Route::get('hapusdataTeknisi/{id}', 'TeknisiController@destroy');

    // api project
    Route::post('tambahProject', 'ProjectController@store');
    Route::post('updatedataProject', 'ProjectController@updatedata');
    Route::get('hapusdataProject/{id}', 'ProjectController@destroy');

    // get all project for masalah
    Route::get('getAllProject','CountController@getAllProject');
    Route::get('getAllMasalah','CountController@getAllMasalah');
    Route::get('getAllAdmin','CountController@getAllAdmin');
    Route::get('getAllTeknisi','CountController@getAllTeknisi');

    // api masalah
    Route::post('tambahMasalah', 'MasalahController@store');
    Route::post('updatedataMasalah', 'MasalahController@updatedata');
    Route::get('hapusdataMasalah/{id}', 'MasalahController@hapusMasalah');
});
