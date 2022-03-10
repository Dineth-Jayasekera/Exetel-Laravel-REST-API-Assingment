<?php

use App\Http\Controllers\CustomerManagement\CustomerManagementController;
use App\Http\Controllers\UserManagement\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'app.auth.token'], function () {

    Route::group(['prefix' => 'user'], function () {

        /**API for user login*/
        Route::post('login', [UserManagementController::class, 'userLogin']);

    });

    Route::group(['middleware' => 'login.status'], function () {

        Route::group(['prefix' => 'customer'], function () {

            /**API for customer creation*/
            Route::post('create', [CustomerManagementController::class, 'createCustomer']);

            /**API for all customers*/
            Route::get('get', [CustomerManagementController::class, 'getCustomers']);

            /**API for update customers*/
            Route::put('update/{id}', [CustomerManagementController::class, 'updateCustomer']);

            /**API for update customers*/
            Route::delete('delete/{id}', [CustomerManagementController::class, 'deleteCustomer']);

        });

    });

});

