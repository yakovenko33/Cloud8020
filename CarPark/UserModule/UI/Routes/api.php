<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')
    //->middleware(['filter.input.data'])
    ->namespace("CarPark\UserModule\UI\Controllers")
    ->group(function () {
        Route::get('/user/test', 'UserController@test');
        Route::post('/user/sing-up', 'UserController@singUp');
        Route::post('/user/sing-in', 'UserController@singIn');
        Route::post('/car-park', 'CarParkController@createCarPark');
        Route::delete('/car-park', 'CarParkController@deleteCarPark');
        Route::delete('/car', 'CarParkController@deleteCar');
        Route::get('/car-parks/list', 'CarParkController@getCarParksList');
        Route::get('/cars/list', 'CarParkController@getCarsList');
    });
