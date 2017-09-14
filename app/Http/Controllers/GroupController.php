<?php

namespace App\Http\Controllers;

use App\Comics;
use App\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Groups::paginate(10);
        $comics = Comics::select('id', 'title')->get();

        return view('groups.index', compact('groups', 'comics'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input      = Input::all();
        $validation = Validator::make($input, Groups::$rules);

        if ($validation->passes()) {
            Groups::create($input);

            return Redirect::route('groups.index');
        }

        return Redirect::route('groups.create')->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
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
        $group = Groups::withTrashed()->find($id);

        return view('groups.show', compact('group'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id )
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $group = Groups::withTrashed()->find($id);

        return (empty($group)) ? Redirect::route('groups.index') : view('groups.edit', compact('group'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id)
    {
        $input      = Input::all();
        $validation = Validator::make($input, Groups::$rules);
        if ($validation->passes()) {
            $user = Groups::withTrashed()->find($id);
            $user->update($input);

            return Redirect::route('groups.show', $id);
        }

        return Redirect::route('groups.edit', $id)->withInput()->withErrors($validation)->with('message', 'There were validation errors.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Groups::withTrashed()->find($id)->delete();

        return Redirect::route('groups.index')->with('success', 'Group was deleted');
    }


    /**
     * Attaches the specified resource in storage to another resource in storage.
     *
     * @param int  $groupId
     * @param  int $comicId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function put($groupId, $comicId)
    {
        $group       = Groups::whereId($groupId)->first();
        $attachedIds = $group->comics()->whereId($comicId)->count();
        switch ($attachedIds) {
            case 0:
                $group->comics()->attach([$comicId]);
                $type    = 'success';
                $message = 'Comic was successfully attached to group!';
                break;
            default:
                $type    = 'error';
                $message = 'Comic was already attached to group!';
        }

        return Redirect::route('groups.index')->with($type, $message);
    }


    public function detach($groupId, $comicId)
    {
        $client = Groups::whereId($groupId)->first();
        if ($client->comics()->detach([$comicId]) > 1) {
            return Redirect::back()->with('error', 'Comic failed to detach from group');
        } else {
            return Redirect::back()->with('sucess', 'Comic was detached from group');
        }
    }
    
    public function balanceSheet()
    {
        $data = Groups::select(['id', 'barcode', 'title'])->with('comics')->get()->toArray();
        foreach ($data as $key => $group) {
            $groupCount = count($group['comics']);
            if ($groupCount > 0) {
                $data[$key]['total'] = $groupCount;
                $data[$key]['subList'] = '';
                $subList = '';
                $subListTitle = 'Comics';
                foreach ($group['comics'] as $comic) {
                    $subList .= '<a href="/groups/detach/' . $group['id'] . '/' . $comic['id'] . '" title="Mark group fulfilled for comic"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;' . $comic['title'] . '</a> | ';
                }
                $data[$key]['subList'] .= substr($subList, 0, -2);
            } else {
                unset($data[$key]);
            }
        }
        
        return view('balancesheet', compact('data', 'subListTitle'));
    }
}
