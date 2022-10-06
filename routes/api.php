<?php

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
    'prefix' => 'place',
    'as' => 'place.',
], function () {
    Route::get('/provinces', 'App\Http\Controllers\API\Share\PlaceController@getProvinces');
    Route::get('/districts/{id}', 'App\Http\Controllers\API\Share\PlaceController@getDistricts');
    Route::get('/wards/{id}', 'App\Http\Controllers\API\Share\PlaceController@getWards');
});

Route::group([], function () {
    Route::post('/login', 'App\Http\Controllers\API\AuthController@login');
    Route::post('/register', 'App\Http\Controllers\API\AuthController@register');
    Route::post('/check_phone', 'App\Http\Controllers\API\AuthController@checkPhone');
    Route::post('/reset_password', 'App\Http\Controllers\API\AuthController@resetPassword');
    Route::group(['prefix' => 'posts'], function () {


        Route::get('/', 'App\Http\Controllers\API\PostController@index');
        Route::get('/{id}', 'App\Http\Controllers\API\PostController@show');
    });
    Route::group(['prefix' => 'posts_categories'], function () {


        Route::get('/', 'App\Http\Controllers\API\ListCategoryController@index');
        Route::get('/{id}', 'App\Http\Controllers\API\ListCategoryController@show');
    });
    Route::middleware('auth_user:api')->group(function () {
        Route::get('/profile', 'App\Http\Controllers\API\AuthController@info');
        Route::put('/profile', 'App\Http\Controllers\API\AuthController@updateInfo')->name('user.update');

        // Route::apiResource('categories', App\Http\Controllers\API\ListCategoryController::class);

        Route::post('/upload/images', 'App\Http\Controllers\API\UploadController@uploadImg');
        // Route::apiResource('posts', App\Http\Controllers\API\PostController::class);
     
    });
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {

    Route::post('/check_phone', 'App\Http\Controllers\API\Admin\AuthController@checkPhone');

    Route::post('/login', 'App\Http\Controllers\API\Admin\AuthController@login');
    Route::post('/register', 'App\Http\Controllers\API\Admin\AuthController@register');
    Route::post('/reset_password', 'App\Http\Controllers\API\Admin\AuthController@resetPassword');


    Route::middleware('auth_admin:api')->group(function () {
        Route::get('/profile', 'App\Http\Controllers\API\Admin\AuthController@info');
        Route::put('/profile', 'App\Http\Controllers\API\Admin\AuthController@updateInfo')->name('user.update');

        Route::apiResource('posts_categories', App\Http\Controllers\API\Admin\ListCategoryController::class);
        Route::post('/upload/images', 'App\Http\Controllers\API\Admin\UploadController@uploadImg');

        Route::apiResource('posts', App\Http\Controllers\API\Admin\PostController::class);
        Route::apiResource('users', App\Http\Controllers\API\Admin\UserController::class);
        Route::apiResource('user_tests', App\Http\Controllers\API\Admin\UserTestController::class);
    });
});
