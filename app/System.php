<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class System extends Model
{
    protected $fillable = [
        'company_id', 'system_name', 'system_description', 'system_location', 'system_type', 'created_by',
    ];
}
