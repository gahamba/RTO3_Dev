<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Device extends Model
{
    protected $connection = 'conn4';
    /*
     * Fillable fields
     */
    protected $fillable = [
        'name', 'unique_id', 'system_id', 'system_name', 'data_points', 'company_id', 'user_id', 'price', 'size', 'misc', 'min_threshold', 'max_threshold', 'description', 'created_by'
    ];
}
