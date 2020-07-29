<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->namespace("CarPark\UserModule\UI\Controllers")
    ->group(function () {
        Route::post('/user/sing-up', 'UserController@singUp');
        Route::post('/user/sing-in', 'UserController@singIn');
    });
