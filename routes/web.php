<?php

Route::any('/test', function () {

    return View::make('landing');
});
Route::any('/', array('as' => 'comics.balancesheet', 'uses' => 'ComicController@balanceSheet'));

Route::any('clients/attach/{clientid}/{comicid}', array('as' => 'clients.put', 'uses' => 'ClientController@put'));
Route::any('comics/attach/{comicid}/{clientid}', array('as' => 'comics.put', 'uses' => 'ComicController@put'));
Route::any('groups/attach/{groupId}/{comicid}', array('as' => 'groups.put', 'uses' => 'GroupController@put'));
Route::any('clients/detach/{clientid}/{comicid}', array('as' => 'clients.detach', 'uses' => 'ClientController@detach'));
Route::any('comics/detach/{comicid}/{clientid}', array('as' => 'comics.detach', 'uses' => 'ComicController@detach'));
Route::any('groups/detach/{groupId}/{comicid}', array('as' => 'groups.detach', 'uses' => 'GroupController@detach'));

Route::any('comics/balancesheet', array('as' => 'comics.balancesheet', 'uses' => 'ComicController@balanceSheet'));
Route::any('comics/wishlist', array('as' => 'comics.wishlist', 'uses' => 'ComicController@wishlist'));
Route::any('clients/balancesheet', array('as' => 'clients.balancesheet', 'uses' => 'ClientController@balanceSheet'));
Route::any('groups/balancesheet', array('as' => 'groups.balancesheet', 'uses' => 'GroupController@balanceSheet'));

Route::resource('clients', 'ClientController');
Route::resource('comics', 'ComicController');
Route::resource('groups', 'GroupController');
Route::resource('metadata', 'MetadataController');
Route::resource('notes', 'NoteController');
Route::resource('orders', 'OrderController');
