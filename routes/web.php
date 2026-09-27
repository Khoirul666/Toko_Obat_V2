<?php

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('home');
    Route::get('home', 'DashboardController@index')->name('home');
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
    /*
     * Pembelian Route
     */
    Route::group(['prefix' => 'pembelian', 'as' => 'pembelian.'], function () {
        Route::get('/', 'PembelianController@index')->name('index');
        Route::post('/', 'PembelianController@add')->name('add');
        Route::get('{draftKey}', 'PembelianController@show')->name('show');
        Route::POST('remove', 'PembelianController@remove')->name('remove');
        Route::post('add-draft-item/{draftKey}/{product}', 'PembelianController@addDraftItem')->name('add-draft-item');
        Route::patch('{draftKey}/proccess', 'PembelianController@proccess')->name('draft-proccess');
        Route::patch('update-draft-item/{draftKey}/{product}', 'PembelianController@updateDraftItem')->name('update-draft-item');
        Route::post('drafts/{draftKey}', 'PembelianController@store')->name('store');
    });
    /*
     * Penjualan Route
     */
    Route::group(['prefix' => 'penjualan', 'as' => 'penjualan.'], function () {
        Route::get('/', 'PenjualanController@index')->name('index');
        Route::post('/', 'PenjualanController@add')->name('add');
        Route::get('{draftKey}', 'PenjualanController@show')->name('show');
        Route::POST('remove', 'PenjualanController@remove')->name('remove');
        Route::post('add-draft-item/{draftKey}/{product}', 'PenjualanController@addDraftItem')->name('add-draft-item');
        Route::patch('update-draft-item/{draftKey}', 'PenjualanController@updateDraftItem')->name('update-draft-item');
        Route::delete('remove-draft-item/{draftKey}', 'PenjualanController@removeDraftItem')->name('remove-draft-item');
        Route::patch('{draftKey}/proccess', 'PenjualanController@proccess')->name('draft-proccess');
        Route::post('drafts/{draftKey}', 'PenjualanController@store')->name('store');
    });
});
