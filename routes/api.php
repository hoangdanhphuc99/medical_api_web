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

Route::group([
], function () {
    Route::post('/login', 'App\Http\Controllers\API\AuthController@login');
    Route::post('/register', 'App\Http\Controllers\API\AuthController@register');
    Route::middleware('auth_user:api')->group(function () {
        Route::get('/profile', 'App\Http\Controllers\API\AuthController@info');

        // Route::apiResource('categories', App\Http\Controllers\API\ListCategoryController::class);
        Route::group(['prefix' => 'categories'], function () {

          
            Route::get('/', 'App\Http\Controllers\API\ListCategoryController@index');
            Route::get('/{id}', 'App\Http\Controllers\API\ListCategoryController@show');
        });
        Route::post('upload_image', 'App\Http\Controllers\API\UploadController@uploadImg');
        // Route::apiResource('posts', App\Http\Controllers\API\PostController::class);
        Route::group(['prefix' => 'posts'], function () {

          
            Route::get('/', 'App\Http\Controllers\API\PostController@index');
            Route::get('/{id}', 'App\Http\Controllers\API\PostController@show');
        });

    });
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {


    Route::post('/login', 'App\Http\Controllers\API\Admin\AuthController@login');
    Route::post('/register', 'App\Http\Controllers\API\Admin\AuthController@register');
    Route::middleware('auth_admin:api')->group(function () {
        Route::get('/profile', 'App\Http\Controllers\API\Admin\AuthController@info');

        Route::apiResource('categories', App\Http\Controllers\API\Admin\ListCategoryController::class);
        Route::post('upload_image', 'App\Http\Controllers\API\Admin\UploadController@uploadImg');
        Route::apiResource('posts', App\Http\Controllers\API\Admin\PostController::class);
        Route::apiResource('users', App\Http\Controllers\API\Admin\UserController::class);


    });
});


