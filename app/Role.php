<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    /*
     * Fillable fields
     */
    protected $fillable = [
        'name', 'display_name', 'icon', 'description',
    ];
}
