<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('showUser');
});
Route::any('/comicManager', function()
{
    return View::make('comicManager');
});
Route::any('/chart1', function()
{
    return View::make('welcome');
});
Route::any('/updateUserInfo', function (){
    $returnArray = ['id' => 1];
    return Response::json($returnArray);
});
*/

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
/*
Route::get('autocomplete', function()
{
    return View::make('autocomplete');
});
Route::get('getdata', function()
{
    $term = Str::lower(Input::get('term'));
    $data = array(
        'R' => 'Red',
        'O' => 'Orange',
        'Y' => 'Yellow',
        'G' => 'Green',
        'B' => 'Blue',
        'I' => 'Indigo',
        'V' => 'Violet',
    );
    $return_array = array();

    foreach ($data as $k => $v) {
        if (strpos(Str::lower($v), $term) !== FALSE) {
            $return_array[] = array('value' => $v, 'id' =>$k);
        }
    }
    return Response::json($return_array);
});
*/

