<?php

namespace App\Http\Controllers;

use App\Correction;
use App\Device;
use App\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use DateTime;

class CorrectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set("Europe/London");
        //
        try{
            $device_id = $request->get('device_id');
            $val = $request->get('val');
            $min = $request->get('min');
            $max = $request->get('max');
            $correction_text = $request->get('correction');
            $day = date("Y-m-d");
            $time = date("H:i");

            $status = 1;
            $msg = 'Sorry, we cannot add device at this time, please try again';

            $correction = new Correction([
                'device_id'     =>  $device_id,
                'user_id'       =>  auth::user()->id,
                'user_name'     =>  auth::user()->name,
                'correction'    =>  $correction_text,
                'time'          =>  $time,
                'date'          =>  $day,
                'val'           =>  $val,
                'min'           =>  $min,
                'max'           =>  $max,
            ]);
            if($correction->save()){

                $status = 0;
                $msg = 'Successfully added';
            }

            $corrections = Correction::where('device_id', '=', $device_id)
                                        ->orderBy('date', 'desc')
                                        ->orderBy('time', 'desc')->get();


            return response()->json(['msg' => $msg, 'status' => $status, 'corrections' => $corrections, 'last_updated' => $time." on ".$day]);

        }
        catch(Exception $ex){
            $msg = $ex;
            $status = 1;
            return response()->json(['msg' => $msg, 'status' => $status]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Correction  $correction
     * @return \Illuminate\Http\Response
     */
    public function show(Correction $correction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Correction  $correction
     * @return \Illuminate\Http\Response
     */
    public function edit(Correction $correction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Correction  $correction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Correction $correction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Correction  $correction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Correction $correction)
    {
        //
    }

    public function fetchCorrections($device_id){
        date_default_timezone_set("Europe/London");
        $corrections = Correction::where('device_id', '=', $device_id)
                                    ->orderBy('date', 'desc')
                                    ->orderBy('time', 'desc')->get();

        //var_dump($corrections[0]);
        if(count($corrections) > 0){
            $last_updated_date_time = new DateTime($corrections[0]->date." ".$corrections[0]->time.":00");
            $now = new DateTime(date("Y-m-d H:i:s"));
            $diff = date_diff($now, $last_updated_date_time, true);
            $diff_mins = ($diff->format("%a") * 24) + ($diff->format("%h") * 60) + $diff->format("%i");
            $textarea = ($diff_mins > 10) ? true : false;
            $last_updated_string = $corrections[0]->time;


            return response()->json(['corrections' => $corrections, 'textarea' => $textarea, 'last_updated' => $last_updated_string]);
        }
        else{
            return response()->json(['corrections' => $corrections, 'textarea' => true, 'last_updated' => '00:00']);
        }




    }
}
