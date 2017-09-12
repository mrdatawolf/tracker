<?php

Route::any('/', function () {

    return View::make('landing');
});

Route::resource('clients', 'ClientController');
Route::any('clients/attach/{$clientId}/{$comicId}', [
    'as'   => 'clients.link',
    'uses' => 'ClientController@link',
]);
Route::resource('comics', 'ComicController');
Route::resource('groups', 'GroupController');
Route::resource('metadata', 'MetadataController');
Route::resource('notes', 'NoteController');
Route::resource('orders', 'OrderController');
Route::resource('watchlists', 'WatchlistController');


