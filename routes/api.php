<?php

use App\Http\Controllers\Auth0\Auth0Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth0-signup', [Auth0Controller::class, 'store']);

Route::post('/request-access-token', [UserController::class, 'issueAccessToken']);

Route::middleware('auth:api')->group(function () {
    Route::get('/userinfo', [UserController::class, 'userInformation']);
});
