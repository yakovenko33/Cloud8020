<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->namespace("CarPark\UserModule\UI\Controllers")
    ->group(function () {
        Route::post('/user/sing-up', 'UserController@singUp');
        Route::post('/user/sing-in', 'UserController@singIn');
//        Route::post('/car-park', 'CarParkController@createCarPark');
//        Route::delete('/car-park', 'CarParkController@deleteCarPark');
//        Route::delete('/car', 'CarParkController@deleteCar');
//        Route::get('/car-parks/list', 'CarParkController@getCarParksList');
//        Route::get('/cars/list', 'CarParkController@getCarsList');
//        Route::get('/car-park', 'CarParkController@getCarPark');
    });
