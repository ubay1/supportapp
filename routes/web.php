<?php


// user authentication
Route::get('admin', 'UserController@index');
Route::get('admin/login', 'UserController@login');
Route::post('admin/loginPost', 'UserController@loginPost');
Route::get('admin/logout', 'UserController@logout');
//end user authentication

// kelola admin
Route::resource('admin/kelolaTS', 'AdminController');
// kelola teknisi
Route::resource('admin/kelolaTeknisi', 'TeknisiController');
// kelola Project
Route::resource('admin/kelolaProject', 'ProjectController');

// kelola Project
Route::get('admin/teknikalProject', 'ProjectController@teknikalProject');

Route::get('admin/getTS', 'ProjectController@getTS');
// end kelola Project

// kelola MasalahProject
Route::resource('admin/kelolaMasalah', 'MasalahController');

// Route::get('/kelolaAdmin/{any}', 'SinglePageController@index')->where('any', '.*');


// Route::get('/{any}', function () {
//     return view('Vueadmin');
// })->where('any','.*');

// Auth::routes(['register' => false]);
