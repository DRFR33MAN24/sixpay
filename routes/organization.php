<?php

use App\Http\Controllers\Organization\Auth\LoginController;
use App\Http\Controllers\Organization\DashboardController;
use App\Http\Controllers\Organization\BusinessSettingsController;
use App\Http\Controllers\Organization\TransactionController;
use App\Http\Controllers\Organization\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Organization', 'as' => 'organization.'], function () {

    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/code/captcha/{tmp}', 'LoginController@captcha')->name('default-captcha');
        Route::get('login', [LoginController::class, 'login'])->name('login');
        Route::post('login', [LoginController::class, 'submit']);
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => ['organization']], function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('settings', [DashboardController::class, 'settings'])->name('settings');
        Route::post('settings', [DashboardController::class, 'settingsUpdate']);
        Route::post('settings-password', [DashboardController::class, 'settingsPasswordUpdate'])->name('settings-password');

        Route::group(['prefix' => 'business-settings', 'as' => 'business-settings.'], function () {
            Route::get('shop-settings', [BusinessSettingsController::class, 'shopIndex'])->name('shop-settings');
            Route::post('shop-settings-update', [BusinessSettingsController::class, 'shopUpdate'])->name('shop-settings-update');
            Route::get('integration-settings', [BusinessSettingsController::class, 'integrationIndex'])->name('integration-settings');
            Route::post('integration-settings-update', [BusinessSettingsController::class, 'integrationUpdate'])->name('integration-settings-update');
        });

        Route::get('/transaction', [TransactionController::class, 'transaction'])->name('transaction');

        Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
            Route::get('/list', [WithdrawController::class, 'list'])->name('list');
            Route::get('/request', [WithdrawController::class, 'withdrawRequests'])->name('request');
            Route::post('/request-store', [WithdrawController::class, 'withdrawRequestStore'])->name('request-store');
            Route::get('/method-data', [WithdrawController::class, 'withdrawMethod'])->name('method-data');
            Route::get('download', [WithdrawController::class, 'download'])->name('download');
        });


    });

});
