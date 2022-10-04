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
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {


    Route::post('/login', 'App\Http\Controllers\API\Admin\AuthController@login');
    Route::post('/register', 'App\Http\Controllers\API\Admin\AuthController@register');
    Route::get('/profile', 'App\Http\Controllers\API\Admin\AuthController@info');
    Route::middleware('authv1:api')->group(function () {

        Route::apiResource('categories', App\Http\Controllers\API\Admin\ListCategoryController::class);
        Route::post('upload_image', 'App\Http\Controllers\API\Admin\UploadController@uploadImg');

    });
});
