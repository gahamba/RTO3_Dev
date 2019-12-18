<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'description', 'created_by',
    ];
}
