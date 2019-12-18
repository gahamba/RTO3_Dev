<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class MongoSystem extends Model
{
    protected $connection = 'conn4';
    protected $table = 'systems';
    protected $fillable = ['sensors'];
}
