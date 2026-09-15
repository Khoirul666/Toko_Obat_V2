<?php

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('home');

    /*
     * Satuan Route
     */
    Route::group(['prefix' => 'satuan', 'as' => 'satuan.'], function () {
        Route::get('/', 'SatuanController@index')->name('index');
        Route::POST('store', 'SatuanController@store')->name('store');
        Route::PATCH('/{satuan}', 'SatuanController@update')->name('update');
        Route::DELETE('/{satuan}', 'SatuanController@destroy')->name('destroy');
    });

    /*
     * Produk Route
     */
    Route::group(['prefix' => 'produk', 'as' => 'produk.'], function () {
        Route::get('/', 'ProdukController@index')->name('index');
        Route::POST('store', 'ProdukController@store')->name('store');
        Route::PATCH('/{produk}', 'ProdukController@update')->name('update');
        Route::DELETE('/{produk}', 'ProdukController@destroy')->name('destroy');
    });

    Route::group(['prefix' => 'penjualan', 'as' => 'penjualan.'], function () {
        Route::get('/', 'PenjualanController@index')->name('index');
        Route::post('/', 'PenjualanController@add')->name('add');
        Route::get('{draftKey}', 'PenjualanController@show')->name('show');
        Route::POST('remove', 'PenjualanController@remove')->name('remove');
    });

    Route::group(['prefix' => 'pembelian', 'as' => 'pembelian.'], function () {
        Route::get('/', 'PembelianController@index')->name('index');
    });
});
