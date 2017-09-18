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
    
            return Redirect::back();
        } else {
            $returnMessage = '';
            foreach ($validation->messages()->getMessages() as $name => $messageArray) {
                $returnMessage .= $name . ': ';
                foreach ($messageArray as $message) {
                    $returnMessage .= $message;
                }
            }
        }
    
        return Redirect::route('comic.create')
            ->withInput()
            ->withErrors($validation)
            ->with('error', 'There were validation errors.')
            ->with('message', $returnMessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $comic = Comics::withTrashed()->find($id);

        return view('comics.show', compact('comic'));
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
        $comic->clients()->attach([$clientId]);

        $this->alterComicTotal($comicId, $clientId, 1);
    
        return Redirect::back()->with('success', 'Client was successfully attached to comic!');
    }

    public function detach($comicId, $clientId)
    {
        $comic = Comics::whereId($comicId)->first();
        ClientsComicsTotals::where(['comics_id' => $comicId, 'clients_id' => $clientId])->forceDelete();
        $comic->clients()->detach([$clientId]);
    
        return Redirect::back()->with('success', 'Client was detached from comic');
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
                    $cct->save();
                }
                break;
            default:
                foreach ($ccts as $cct) {
                    $cct->total += $adjustment;
                    if ($cct->total > 0) {
                        $cct->save();
                    } else {
                        $cct->forceDelete();
                    }
                }
                break;
        }

        return true;
    }
    
    public function balanceSheet()
    {
        $balanceTitle = 'Comic Balance';
        $data = Comics::select(['id', 'barcode', 'title', 'number'])->with('clients')->get()->toArray();
        foreach ($data as $key => $comic) {
            $clientCount = ClientsComicsTotals::where('comics_id', $comic['id'])->count();
            if ($clientCount > 0) {
                $data[$key]['total'] = $clientCount;
                $data[$key]['subList'] = '';
                $subList = '';
                $subListTitle = 'Clients';
                foreach ($comic['clients'] as $client) {
                    $subList .= '<a href="/comics/detach/' . $comic['id'] . '/' . $client['id'] . '" title="Mark comic fulfilled for client"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;' . $client['name'] . '</a> | ';
                }
                $data[$key]['subList'] .= substr($subList, 0, -2);
            } else {
                unset($data[$key]);
            }
        }
    
        return view('balancesheet', compact('data', 'subListTitle', 'balanceTitle'));
    }
    
    public function wishList()
    {
        $balanceTitle = 'Comic Wishlist';
        $data         = Comics::select(['id', 'barcode', 'title', 'number'])->with('clients')->get()->toArray();
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
        
        return view('balancesheet', compact('data', 'subListTitle', 'balanceTitle'));
    }
}
