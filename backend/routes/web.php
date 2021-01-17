<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'BooksController@index');
    Route::resource('/books', 'BooksController', ['only' => ['index', 'store', 'edit', 'update', 'destroy']]);
});


//Auth
Auth::routes();
Route::get('/home', 'BooksController@index')->name('home');
