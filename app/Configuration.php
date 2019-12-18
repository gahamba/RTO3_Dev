<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'companyId', 'times', 'createdBy',
    ];
}
