<?php

namespace App\Http\Controllers;

use App\Clients;
use App\ClientsComicsTotals;
use App\Comics;
use Illuminate\Http\Request;
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
                $this->alterComicTotal($comicId, $clientId, 1);
                $type = 'success';
                $message = 'Client was successfully attached to comic!';
                break;
            default:
                $type = 'error';
                $message = 'Client was already attached to comic!';
        }

        return Redirect::route('comics.index')->with($type, $message);
    }


    public function detach($comicId, $clientId)
    {
        $comic = Comics::whereId($comicId)->first();
        if ($comic->clients()->detach([$clientId]) > 1) {
            return Redirect::back()->with('error', 'Client failed to detach from comic');
        } else {
            $this->alterComicTotal($comicId, $clientId, -1);

            return Redirect::back()->with('success', 'Client was detached from comic');
        }
    }


    /**
     * @param $comicId
     * @param $clientId
     * @param $adjustment
     *
     * @return bool
     */
    public function alterComicTotal($comicId, $clientId, $adjustment)
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
        $data = Comics::select(['id', 'barcode', 'title', 'number'])->with('clients')->get()->toArray();
        foreach ($data as $key => $comic) {
            $clientCount = ClientsComicsTotals::where('comics_id', $comic['id'])->count();
            if ($clientCount > 0) {
                $data[$key]['total']   = $clientCount;
                $data[$key]['subList'] = '';
                $subList               = '';
                $subListTitle          = 'Clients';
                foreach ($comic['clients'] as $client) {
                    $subList .= '<a href="/comics/detach/'.$comic['id'].'/'.$client['id'].'" title="Mark comic fulfilled for client"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;'.$client['name'].'</a> | ';
                }
                $data[$key]['subList'] .= substr($subList, 0, -2);
            } else {
                unset($data[$key]);
            }
        }

        return view('balancesheet', compact('data', 'subListTitle'));
    }
}
