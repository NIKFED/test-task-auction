<?php

Auth::routes();

Route::get('', 'HomeController@index')->middleware(['auth', 'confirmed']);

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth', 'confirmed']);

Route::post('/users/balance', 'UserInformationController@getBalance')->name('user-balance')->middleware(['auth', 'confirmed']);
Route::post('/users/balancewriting', 'UserInformationController@writingBalance')->name('user-balance-writing')->middleware(['auth', 'confirmed']);
Route::post('/users/checkadmin', 'UserInformationController@checkAdmin')->name('checkadmin')->middleware(['auth', 'confirmed']);
Route::post('/users/name', 'UserInformationController@getName')->name('user-name')->middleware(['auth', 'confirmed']);

Route::get('/pictures', 'PicturesController@index')->name('start-page')->middleware(['auth', 'confirmed']);
Route::get('/pictures/all', 'PicturesController@getAllPictures')->middleware(['auth', 'confirmed']);

Route::get('/pictures/view/{id}', 'PicturesController@view')->name('view-picture')->middleware(['auth', 'confirmed']);
Route::get('/pictures/create', 'PicturesController@create')->middleware(['auth', 'confirmed']);

Route::get('/auction', 'AuctionController@index')->middleware(['auth', 'confirmed']);
Route::post('/auction/start', 'AuctionSettingsController@auctionStart')->middleware(['auth', 'confirmed']);
Route::post('/auction/end', 'AuctionSettingsController@auctionEnd')->middleware(['auth', 'confirmed']);
Route::get('/auction/settings', 'AuctionSettingsController@getTimer')->middleware(['auth', 'confirmed']);
Route::post('/auction/picture', 'AuctionSettingsController@setPictureData')->middleware(['auth', 'confirmed']);
Route::post('/auction/chat', 'ChatController@setMessage')->name('send-message')->middleware(['auth', 'confirmed']);

Route::get('/buys', 'BuysController@index')->middleware(['auth', 'confirmed']);


// confirm email
Route::get('users/{user}/request-confirmation', 'UsersEmailConfirmationController@request')->name('request-confirm-email')->middleware('auth');
Route::post('users/{user}/send-confirmation-email', 'UsersEmailConfirmationController@sendEmail')->name('send-confirmation-email')->middleware('auth');
Route::get('users/{user}/confirm-email/{token}', 'UsersEmailConfirmationController@confirm')->name('confirm-email');
