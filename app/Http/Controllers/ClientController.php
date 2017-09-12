<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Comics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $clients       = Clients::paginate(10);
        $comics        = Comics::select('id', 'title')->get();
        $clientToComic = [];

        return view('clients.index', compact('clients', 'clientToComic', 'comics'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $input = Input::all();
        $validation = Validator::make($input, Clients::$rules);
        
        if ($validation->passes()) {
            Clients::create($input);
            
            return Redirect::route('clients.index');
        }
        
        return Redirect::route('clients.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $client = Clients::withTrashed()->find($id);
        
        return view('clients.show', compact('client'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $client = Clients::withTrashed()->find($id);
        
        return (empty($client)) ? Redirect::route('clients.index') : view('clients.edit', compact('client'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id)
    {
        $input = Input::all();
        $validation = Validator::make($input, Clients::$rules);
        if ($validation->passes()) {
            $user = Clients::withTrashed()->find($id);
            $user->update($input);
            return Redirect::route('clients.show', $id);
        }
        return Redirect::route('clients.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }


    /**
     * Links the specified resource in storage to another resource in storage.
     *
     * @param  int $clientId
     * @param  int $comicId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attach($clientId, $comicId)
    {

        return Redirect::route('clients.index')->with('success', 'Client '.$clientId.'and comic linked '.$comicId);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        Clients::withTrashed()->find($id)->delete();
        return Redirect::route('clients.index')
            ->with('success', 'Client was deleted');
    }
}
