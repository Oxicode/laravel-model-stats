<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('model-stats.routes_prefix'))
    ->middleware('model-stats')
    ->name(config('model-stats.route_names_prefix'))->group(function () {

        Route::prefix('api')->name('api.')->group(function () {
            Route::apiResource('dashboards', \Jhumanj\LaravelModelStats\Http\Controllers\DashboardController::class);
            Route::post('widgets/data',
                [\Jhumanj\LaravelModelStats\Http\Controllers\StatController::class, 'widgetData']);
        });

        Route::get('/{view?}', [\Jhumanj\LaravelModelStats\Http\Controllers\HomeController::class, 'home'])
            ->name('dashboard')
            ->where('view', '^(?!api).*$');
    });
