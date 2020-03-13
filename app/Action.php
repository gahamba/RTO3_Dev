<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Action extends Model
{
    protected $connection = 'conn4';
    protected $fillable = [
        'action', 'created_by', 'company_id',
    ];
}
