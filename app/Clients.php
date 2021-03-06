<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use SoftDeletes;
    
    /**
     * @var array
     */
    public static $rules = [
        'name' => 'unique:Clients,name|required|min:5'
    ];
    
    /**
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * @var array
     */
    protected $fillable = ['barcode', 'name', 'email', 'phone', 'other'];
    
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
    public function totals()
    {
        return $this->belongsToMany('App\ClientsComicsTotals');
    }
}
