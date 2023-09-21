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

// This route does not need to be in the auth middleware group
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::get('/auth', 'AuthController@auth');

// Define a route group for protected routes that require authentication
// Route::middleware(['auth:api'])->group(function () {
    Route::post('/product', 'ProductController@store');
    Route::post('/account/update', 'AuthController@updatePassword');
    Route::post('/batch', 'BatchController@store');
    Route::get('/batches', 'BatchController@index');
    Route::get('/batch/{batchId}', 'BatchController@findByBatch');


    Route::get('/products', 'ProductController@index');
    Route::delete('/batch/{id}', 'BatchController@destroy');
    Route::delete('/product/{id}', 'ProductController@destroy');
    Route::patch('/batch/{id}', 'BatchController@update');
    Route::patch('/product/{id}', 'ProductController@update');
// });


Route::get('/{any}', function ($any) {
   
    return "Resources not available";
});


Route::post('/{any}', function ($any) {
   
    return "Resources not available";
});