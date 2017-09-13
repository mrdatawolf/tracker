<?php

namespace App\Http\Controllers;

use App\ClientsComicsTotals;

class ClientsComicsTotalsController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $comicId
     * @param  int $clientId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($comicId, $clientId)
    {
        ClientsComicsTotals::withTrashed()->where(['comic_ic' => $comicId, 'client_id' => $clientId])->delete();
        
        return redirect()->back()->with('success', 'Link was broken');
    }
}
