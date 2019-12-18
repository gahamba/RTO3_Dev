<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Reading extends Model
{
    /*
     * Fillable fields
     */
    protected $fillable = [
        'unique_id', 'value',
    ];
}
