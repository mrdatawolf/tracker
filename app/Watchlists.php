<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * meant to track requests people have on
 * Class Watchlists
 * @package App
 */
class Watchlists extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];
    
    /**
     * The comics that belong to the client.
     */
    public function comics()
    {
        return $this->belongsToMany('App\Comics');
    }
    
    /**
     * The clients that belong to the comic.
     */
    public function clients()
    {
        return $this->belongsToMany('App\Clients');
    }
}
