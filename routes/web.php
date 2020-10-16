<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.home');
});

//Login and register
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//Products
Route::view('/products', 'product');
Route::resource('/categories', 'CategoryController');
Route::resource('/products-resource', 'ProductController');
Route::get('/searchProducByDates/{initDate}/{endDate}', 'ProductController@searchProducByDates');

//folder tree
Route::view('/folder-tree', 'folderTree');
Route::resource('/folders', 'FolderController');