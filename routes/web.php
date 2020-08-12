<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Json;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => 'auth'
    ],
    function () {

        Route::get('/', function () {
            return view('admin.master');
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('page/{page}', 'CategoryController@index')->where(['page' => '^[0-9]+$']);
            Route::get('search/', ['as' => 'category.search', 'uses' => 'Services\CategoryService@search']);
            Route::get('search/{search}', ['as' => 'category.search', 'uses' => 'Services\CategoryService@search']);
            Route::get('sort/{sort}/{order}', 'Services\CategoryService@getSortList');
        });
        Route::resource('category', 'CategoryController');
        
        Route::group(['prefix' => 'product'], function() {
            Route::get('sub-image/{id}/delete', 'Services\ProductImageService@delete');
            Route::get('page/{page}', 'ProductController@index')->where(['page' => '^[0-9]+$']);
            Route::get('search/', ['as' => 'product.search', 'uses' => 'Services\ProductService@search']);
            Route::get('search/{search}', ['as' => 'product.search', 'uses' => 'Services\ProductService@search']);
            Route::get('sort/{sort}/{order}', 'Services\ProductService@getSortList');
        });        
        Route::resource('product', 'ProductController');
    }
);