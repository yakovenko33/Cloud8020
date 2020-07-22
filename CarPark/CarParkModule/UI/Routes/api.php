<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->namespace("CarPark\CarParkModule\UI\Controllers")
    ->group(function () {
        Route::post('/car-park', 'CarParkController@createCarPark');
        Route::delete('/car-park', 'CarParkController@deleteCarPark');
        Route::delete('/car', 'CarParkController@deleteCar');
        Route::get('/car-parks/list', 'CarParkController@getCarParksList');
        Route::get('/cars/list', 'CarParkController@getCarsList');
        Route::get('/car-park', 'CarParkController@getCarPark');
    });
