<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientsComicsTotals
 *
 * @property int $clients_id
 * @property int $comics_id
 * @property int $total
 *
 * @package App
 */
class ClientsComicsTotals extends Model
{
    /**
     * @var array
     */
    public static $rules      = [];
    public        $timestamps = false;
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $fillable = ['clients_id', 'comics_id', 'total'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

}