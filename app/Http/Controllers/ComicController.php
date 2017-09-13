<?php

namespace App\Http\Controllers;

use App\Clients;
use App\ClientsComicsTotals;
use App\Comics;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteUrlGenerator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comics = Comics::paginate(10);
        $clients = Clients::select('id', 'name')->get();
    
        return view('comics.index', compact('comics', 'clients'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comics.create');
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
        $validation = Validator::make($input, Comics::$rules);
    
        if ($validation->passes()) {
            Comics::create($input);
        
            return Redirect::route('comics.index');
        }
    
        return Redirect::route('comic.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $comic = Comics::withTrashed()->find($id);
    
        return (empty($comic)) ? Redirect::route('comics.index') : view('comics.edit', compact('comic'));
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
        $validation = Validator::make($input, Comics::$rules);
        if ($validation->passes()) {
            $comic = Comics::withTrashed()->find($id);
            $comic->update($input);
            return Redirect::route('comics.show', $id);
        }
        return Redirect::route('comics.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        Comics::withTrashed()->find($id)->delete();
    
        return redirect()->back()->with('success', 'Comic was deleted');
    }

    /**
     * Attaches the specified resource in storage to another resource in storage.
     *
     * @param $comicId
     * @param $clientId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function put($comicId, $clientId)
    {
        $comic = Comics::whereId($comicId)->first();
        $attachedIds = $comic->clients()->whereId($clientId)->count();
        switch ($attachedIds) {
            case 0:
                $comic->clients()->attach([$clientId]);
                $totals             = new ClientsComicsTotals();
                $totals->clients_id = $clientId;
                $totals->comics_id  = $comicId;
                $totals->total      = 1;
                $totals->save();
                $type = 'success';
                $message = 'Client was successfully attached to comic!';
                break;
            default:
                $type = 'error';
                $message = 'Client was already attached to comic!';
        }

        return Redirect::route('comics.index')->with($type, $message);
    }


    public function balanceSheet()
    {
        $data = Comics::select(['id', 'barcode', 'title', 'number'])->with('clients')->get()->toArray();
        foreach ($data as $key => $comic) {
            $data[$key]['total']   = ClientsComicsTotals::where('comics_id', $comic['id'])->count();
            $data[$key]['subList'] = '';
            $subList               = '';
            foreach ($comic['clients'] as $client) {
                $subList .= '<a href=comics/detach/' . $comic['id'] . '/' . $client['id'] . '>' . $client['name'] . '</a>, ';
            }
            $data[$key]['subList'] .= substr($subList, 0, -2);
        }

        return view('balancesheet', compact('data'));
    }
}
