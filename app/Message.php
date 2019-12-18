<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Message extends Model
{
    //
    protected $connection = 'conn4';
    protected $fillable = [
        'sensorId', 'user_id', 'subject', 'message', 'sent', 'read', 'status', 'time',
    ];
}
