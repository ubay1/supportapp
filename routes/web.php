<?php


// user authentication
Route::prefix('admin')->group(function(){
    Route::get('/', 'UserController@index');
    Route::get('/login', 'UserController@login');
    Route::post('/loginPost', 'UserController@loginPost');
    Route::get('/logout', 'UserController@logout');
    //end user authentication

    // kelola admin
    Route::resource('/kelolaTS', 'AdminController');
    // kelola teknisi
    Route::resource('/kelolaTeknisi', 'TeknisiController');
    // kelola Project
    Route::resource('/kelolaProject', 'ProjectController');

    // kelola Project
    Route::get('/teknikalProject', 'ProjectController@teknikalProject');

    // kelola MasalahProject
    Route::resource('/kelolaMasalah', 'MasalahController');

    Route::get('/getTS', 'ProjectController@getTS');
    // end kelola Project

});
// Route::get('/kelola/{any}', 'SinglePageController@index')->where('any', '.*');


Route::get('/{any}', function () {
    return view('layouts/app');
})->where('any','.*');

// Auth::routes(['register' => false]);
