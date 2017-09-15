<?php

namespace App\Http\Controllers;

use App\Clients;
use App\ClientsComicsTotals;
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
        $comics = Comics::select('id', 'number', 'title')->get();
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        Clients::withTrashed()->find($id)->delete();
        return Redirect::route('clients.index')->with('success', 'Client was deleted');
    }


    /**
     * Attaches the specified resource in storage to another resource in storage.
     *
     * @param Request $request
     * @param int     $clientId
     * @param  int    $comicId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function put(Request $request, $clientId, $comicId)
    {
        $client      = Clients::whereId($clientId)->first();
        $attachedIds = $client->comics()->whereId($comicId)->count();
        switch ($attachedIds) {
            case 0:
                $client->comics()->attach([$comicId]);
                $this->alterComicTotal($clientId, $comicId, 1);
                $type    = 'success';
                $message = 'Comic was successfully attached to client!';
                break;
            default:
                $type    = 'error';
                $message = 'Comic was already attached to client!';
        }

        return Redirect::route('clients.index')->with($type, $message);
    }


    public function detach($clientId, $comicId)
    {
        $client = Clients::whereId($clientId)->first();
        if ($client->comics()->detach([$comicId]) > 1) {
            return Redirect::back()->with('error', 'Comic failed to detach from client');
        } else {
            $this->alterComicTotal($clientId, $comicId, -1);

            return Redirect::back()->with('sucess', 'Comic was detached from client');
        }
    }


    /**
     * @param $clientId
     * @param $comicId
     * @param $adjustment
     *
     * @return bool
     */
    public function alterComicTotal($clientId, $comicId, $adjustment)
    {
        $ccts = ClientsComicsTotals::where(['comics_id' => $comicId, 'clients_id' => $clientId]);
        switch ($ccts->count()) {
            case 0:
                if ($adjustment > 0) {
                    $cct             = new ClientsComicsTotals();
                    $cct->clients_id = $clientId;
                    $cct->comics_id  = $comicId;
                    $cct->total      += $adjustment;
                    if ($cct->total < 1) {
                        $cct->delete();
                    } else {
                        $cct->save();
                    }
                }
                break;
            case 1:
                $cct        = $ccts->first();
                $cct->total += $adjustment;
                $cct->save();
                break;
            default:

                return false;
        }

        return true;
    }

    public function balanceSheet()
    {
        $data = Clients::select(['id', 'barcode', 'name'])->with('comics')->get()->toArray();
        foreach ($data as $key => $client) {
            $data[$key]['total']   = ClientsComicsTotals::where('clients_id', $client['id'])->count();
            $data[$key]['subList'] = '';
            $subList               = '';
            $subListTitle          = 'Comics';
            foreach ($client['comics'] as $comic) {
                $subList .= '<a href="/clients/detach/'.$client['id'].'/'.$comic['id'].'" title="Mark comic fulfilled for client"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;'.$comic['title'].':'.$comic['number'].'</a> | ';
            }
            $data[$key]['subList'] .= substr($subList, 0, -2);
        }

        return view('balancesheet', compact('data', 'subListTitle'));
    }
}
