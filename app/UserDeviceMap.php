<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class UserDeviceMap extends Model
{
    protected $fillable = [
        'user_id', 'system_id', 'device_id',
    ];
}
