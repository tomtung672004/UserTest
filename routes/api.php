<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::apiResource('users',App\Http\Controllers\API\UserController::class);*/
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    route::get('profile', [App\Http\Controllers\AuthController::class, 'profile']);
    route::put('tasks/submit/{id}', [App\Http\Controllers\API\TaskController::class, 'submit']);
    route::resource('users',App\Http\Controllers\API\UserController::class);
    route::resource('jobs',App\Http\Controllers\API\JobController::class);
    route::resource('tasks',App\Http\Controllers\API\TaskController::class);
});
