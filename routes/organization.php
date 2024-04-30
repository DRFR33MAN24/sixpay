<?php

use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Organization\Auth\LoginController;
use App\Http\Controllers\Organization\DashboardController;
use App\Http\Controllers\Organization\BusinessSettingsController;
use App\Http\Controllers\Organization\TransactionController;
use App\Http\Controllers\Organization\TransferController;
use App\Http\Controllers\Organization\WithdrawController;
use App\Http\Controllers\Organization\CustomerController;
use App\Http\Controllers\Organization\ExpenseController;
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

        Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
            Route::get('index', [TransactionController::class, 'index'])->name('index');
            Route::post('store', [TransactionController::class, 'store'])->name('store');

            Route::get('request-money', [TransactionController::class, 'requestMoney'])->name('request_money');
            Route::get('request-money-status/{slug}', [TransactionController::class, 'requestMoneyStatusChange'])->name('request_money_status_change');
            Route::get('get-user', [TransferController::class, 'getUser'])->name('get_user');
        });

        Route::group(['prefix' => 'transfer', 'as' => 'transfer.'], function () {
            Route::get('index', [TransferController::class, 'index'])->name('index');
            Route::post('store', [TransferController::class, 'store'])->name('store');
            Route::get('get-user', [TransferController::class, 'getUser'])->name('get_user');
        });

        Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
            Route::get('requests', [WithdrawController::class, 'index'])->name('requests');
            Route::get('status-update', [WithdrawController::class, 'status_update'])->name('status_update');
            Route::get('download', [WithdrawController::class, 'download'])->name('download');
        });

        Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
            Route::get('index', [ExpenseController::class, 'index'])->name('index');
        });

        Route::group(['prefix' => 'customer', 'as' => 'customer.', 'middleware' => []], function () {
            Route::get('tags-list', [CustomerController::class, 'tagsList'])->name('tags-list');
            Route::post('add-tags', [CustomerController::class, 'add_tags'])->name('add-tags');
            Route::get('delete-tag/{id}', [CustomerController::class, 'delete_tag'])->name('delete-tag');
            Route::get('edit-tag/{id}', [CustomerController::class, 'edit_tag'])->name('edit-tag');
            Route::post('update-tag/{id}', [CustomerController::class, 'update_tag'])->name('update-tag');
            Route::get('add', [CustomerController::class, 'index'])->name('add');
            Route::post('store', [CustomerController::class, 'store'])->name('store');
            Route::get('list', [CustomerController::class, 'customerList'])->name('list');
            Route::get('view/{user_id}', [CustomerController::class, 'view'])->name('view');
            Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [CustomerController::class, 'update'])->name('update');
            Route::get('transaction/{user_id}', [CustomerController::class, 'transaction'])->name('transaction');
            Route::get('log/{user_id}', [CustomerController::class, 'log'])->name('log');
            Route::post('search', [CustomerController::class, 'search'])->name('search');
            Route::get('status/{id}', [CustomerController::class, 'status'])->name('status');
            Route::get('kyc-requests', [CustomerController::class, 'getKycRequest'])->name('kyc_requests');
            Route::get('kyc-status-update/{id}/{status}', [CustomerController::class, 'updateKycStatus'])->name('kyc_status_update');
        });

        Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => []], function () {

            Route::get('transaction/{user_id}', [OrganizationController::class, 'transaction'])->name('transaction');
            Route::get('view/{user_id}', [OrganizationController::class, 'view'])->name('view');
        });



        Route::get('organization/transaction/{user_id}', [OrganizationController::class, 'transaction'])->name('organization.transaction');
        Route::get('organization/view/{user_id}', [OrganizationController::class, 'view'])->name('organization.view');


    });

});
