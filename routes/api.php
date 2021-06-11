<?php

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

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('profile', 'AuthController@profile');

});

Route::group(['namespace' => 'Config'], function () {
    Route::group(['prefix' => 'account-group'], function () {
        Route::post('', 'AccountGroupController@data');
        Route::get('list', 'AccountGroupController@dropdown');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::post('', 'CategoriesController@data');
        Route::get('list/{type}', 'CategoriesController@dropdown');
    });
});

Route::group(['namespace' => 'Transaction'], function () {
    Route::group(['prefix' => 'images'], function () {
        Route::get('{id}', 'ImagesController@show');
        Route::delete('{id}/delete', 'ImagesController@delete');
    });

    //for http post method, $request must have $request->user_id;
    Route::group(['prefix' => 'accounts'], function () {
        Route::post('', 'AccountsController@data');
        Route::get('{id}', 'AccountsController@show');
        Route::get('list/{user_id}', 'AccountsController@dropdown');
        Route::post('create', 'AccountsController@create');
        Route::match(['patch', 'put'], '{id}/update', 'AccountsController@update');
        Route::delete('{id}/delete', 'AccountsController@delete');
        Route::post('trashed', 'AccountsController@trashed');
        Route::post('{id}/restore', 'AccountsController@restore');
    });

    //for http post method, $request must have $request->user_id;
    Route::group(['prefix' => 'transactions'], function () {
        /**
         * optional $request for show paginate data:
         * $request->filters_<<table_attribute>>
         * $request->search_value
         **/
        Route::post('', 'TransactionsController@data');
        Route::get('{id}', 'TransactionsController@show');
        Route::post('create', 'TransactionsController@create');
        Route::match(['patch', 'put'], '{id}/update', 'TransactionsController@update');
        Route::delete('{id}/delete', 'TransactionsController@delete');
        Route::post('trashed', 'TransactionsController@trashed');
        Route::post('{id}/restore', 'TransactionsController@restore');

        /**
         * optional $request for summary:
         * $request->summary_based_on = 'daily|monthly' (if this $request is not exist, it will return daily).
         * $request->start_date (if this $request is not exist, it will return last month).
         * $request->end_date (if this $request is not exist, it will return today).
         */
        Route::post('summary/by-date', 'TransactionsController@summaryByDateOnly');
        Route::post('summary/by-type-category', 'TransactionsController@summaryByTypeAndCategory');
        Route::post('summary/by-all', 'TransactionsController@summaryByAll');
    });
});

