<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')
    //->middleware(['filter.input.data'])
    ->namespace("CarPark\UserModule\UI\Controllers")
    ->group(function () {
        Route::get('/user/test', 'UserController@test');
        Route::post('/user/sing-up', 'UserController@singUp');
        Route::post('/user/sing-in', 'UserController@singIn');
        Route::post('/cars-park', 'CarParkController@createCarPark');
    });
