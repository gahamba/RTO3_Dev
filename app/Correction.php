<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Correction extends Model
{
    protected $fillable = [
        'device_id', 'user_id', 'user_name', 'correction', 'time', 'date', 'val', 'min', 'max',
    ];
}
