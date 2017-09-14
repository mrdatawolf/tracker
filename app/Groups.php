<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groups extends Model
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
    protected $fillable = ['barcode', 'title'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];


    public function tags()
    {
        return $this->belongsToMany('Tag');
    }


    /**
     * The clients that belong to the comic.
     */
    public function comics()
    {
        return $this->belongsToMany('\App\Comics');
    }


    /**
     * The clients that belong to the comic.
     */
    public function clients()
    {
        return $this->belongsToMany('\App\Clients');
    }
}
