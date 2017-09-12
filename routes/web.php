<?php

Route::any('/', function () {

    return View::make('landing');
});
Route::resource('clients', 'ClientController');
Route::resource('comics', 'ComicController');
Route::resource('groups', 'GroupController');
Route::resource('metadata', 'MetadataController');
Route::resource('notes', 'NoteController');
Route::resource('orders', 'OrderController');
Route::resource('watchlists', 'WatchlistController');
Route::any('clients/attach/{clientid}/{comicid}', array('as' => 'clients.put', 'uses' => 'ClientController@put'));
Route::any('comics/attach/{comicid}/{clientid}', array('as' => 'comics.put', 'uses' => 'ComicController@put'));
