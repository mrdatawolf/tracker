<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comics
 *
 * @property-read \App\Clients $clients
 *
 * @package App
 */
class Comics extends Model
{
    use SoftDeletes;
    
    /**
     * @var array
     */
    public static $rules = [];
    
    /**
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * @var array
     */
    protected $fillable = ['barcode', 'title', 'number', 'notes'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];
    
    /**
     * The clients that belong to the comic.
     */
    public function clients()
    {
        return $this->belongsToMany('App\Clients');
    }


    /**
     * The clients that belong to the comic.
     */
    public function totals()
    {
        return $this->belongsToMany('App\ClientsComicsTotals');
    }


    /**
     * The clients that belong to the comic.
     */
    public function groups()
    {
        return $this->belongsToMany('App\Groups');
    }
}
