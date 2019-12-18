<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Datapoint extends Model
{
    //
    protected $connection = 'conn4';
    protected $table = 'datapoints';
}
