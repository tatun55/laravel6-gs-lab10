<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'BooksController@index');
    Route::resource('books', 'BooksController', ['only' => ['index', 'store', 'edit', 'update', 'destroy']]);
    Route::resource('books.bookComments', 'BookCommentController', ['only' => ['store', 'destroy']])->shallow();
});


//Auth
Auth::routes();
Route::get('/home', 'BooksController@index')->name('home');
