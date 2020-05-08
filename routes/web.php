<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => 'auth'        
    ], function () {
        Route::get('/', function () {
            return view('admin.master');
        });
    
        Route::get('category/page/{page}','CategoryController@index')->where(['page' => '^[0-9]+$']);
        Route::get('category/page/{page}/search/{search}','CategoryController@index')->where(['page' => '^[0-9]+$']);
        Route::get('category/sort', 'CategoryController@getSortList');

        Route::resource('category', 'CategoryController');                
    }
);