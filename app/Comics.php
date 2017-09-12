<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comics extends Model
{
    use SoftDeletes;
    
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
        return $this->belongsToMany('Clients');
    }


    /**
     * The clients that belong to the comic.
     */
    public function groups()
    {
        return $this->belongsToMany('Groups');
    }
}
