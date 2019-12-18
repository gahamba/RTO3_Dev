<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;

class DateController extends Controller
{
    //
    public function convertMongoToY_M_D($mongotime){

        $timestamp = date('Y-m-d');
        foreach($mongotime as $t){
            $timestamp = date("Y-m-d", $t/1000);
        }

        return $timestamp;
    }

    public function convertMongoToY_M_D_H_i_s($mongotime){

        $timestamp = date('Y-m-d H:i:s');
        foreach($mongotime as $t){
            $timestamp = date("Y-m-d H:i:s", $t/1000);
        }

        return $timestamp;
    }

    public function convertY_M_DToMongoISO_Start($date){

        $from = new DateTime($date." 00:00:00");

        $date = DateTime::createFromFormat('Y-m-d\TH:i:s.uT', date("Y-m-d\TH:i:s.uT", $from->format('U')));
        //var_dump(new UTCDateTime($date->format('U') * 1000));

        return new UTCDateTime($date->format('U') * 1000);

    }

    public function convertY_M_DToMongoISO_End($date){

        $to = new DateTime($date." 23:59:59");
        //var_dump(new UTCDateTime($to->format('U') * 1000));
        return new UTCDateTime($to->format('U') * 1000);

    }
}
