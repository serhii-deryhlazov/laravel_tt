<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\AuthenticatedSessionController;
use Laravel\Passport\Http\Controllers\ScopeController;
use Laravel\Passport\Http\Controllers\TransientTokenController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api')->group(function () {

    Route::get('/customers', 'CustomerController@index');
    Route::get('/customers/take/{n}', 'CustomerController@get');
    Route::get('/customers/{id}', 'CustomerController@show');
    Route::post('/customers', 'CustomerController@store');
    Route::put('/customers/{id}', 'CustomerController@update');
    Route::delete('/customers/{id}', 'CustomerController@destroy');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::post('tokens', [AccessTokenController::class, 'issueToken']);
    Route::middleware('auth:api')->group(function () {
        Route::get('user', function (Request $request) {
            return $request->user();
        });
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
        Route::post('authorize', [AuthorizationController::class, 'store']);
        Route::delete('authorize/{auth_code_id}', [AuthorizationController::class, 'destroy']);
        Route::post('scopes', [ScopeController::class, 'store']);
        Route::delete('scopes/{scope_id}', [ScopeController::class, 'destroy']);
        Route::post(' transient_token', [TransientTokenController::class, 'store']);
    });
});
