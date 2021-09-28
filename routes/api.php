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

Route::post('/auth/token', 'APITokenController@login');
Route::post('/user/register', 'APITokenController@register');
Route::post('/user/varify/moile', 'APITokenController@varifyMobile');


Route::group(['prefix' => 'member', 'middleware' => ['auth:sanctum']], function() {
    Route::post('/dashboard', 'APITokenController@dashboard');
});

