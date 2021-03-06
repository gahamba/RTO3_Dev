<?php

namespace App\Http\Controllers;

use App\Action;
use App\Correction;
use App\Device;
use App\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use DateTime;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Message;
use App\UserDeviceMap;
use Illuminate\Support\Facades\Mail;


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
        $actions = Action::where('company_id', '=', auth::user()->company_id)->get();

        //var_dump($corrections[0]);
        if(count($corrections) > 0){
            $last_updated_date_time = new DateTime($corrections[0]->date." ".$corrections[0]->time.":00");
            $now = new DateTime(date("Y-m-d H:i:s"));
            $diff = date_diff($now, $last_updated_date_time, true);
            $diff_mins = ($diff->format("%a") * 24) + ($diff->format("%h") * 60) + $diff->format("%i");
            $textarea = ($diff_mins > 10) ? true : false;
            $last_updated_string = $corrections[0]->time;


            return response()->json(['corrections' => $corrections, 'textarea' => $textarea, 'last_updated' => $last_updated_string, 'actions' => $actions]);
        }
        else{
            return response()->json(['corrections' => $corrections, 'textarea' => true, 'last_updated' => '00:00', 'actions' => $actions]);
        }




    }

    public function doAcknowledgement($device_id, $reading, $min_threshold, $max_threshold){
        date_default_timezone_set("Europe/London");
        $device = Device::where('sensor_id', '=', floatval($device_id))->first();
        $corrections = Correction::where('device_id', '=', $device->id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')->get();

        $device_array = array($device_id, $reading, $min_threshold, $max_threshold);

        //var_dump($corrections[0]);
        if(count($corrections) > 0){
            $last_updated_date_time = new DateTime($corrections[0]->date." ".$corrections[0]->time.":00");
            $now = new DateTime(date("Y-m-d H:i:s"));
            $diff = date_diff($now, $last_updated_date_time, true);
            $diff_mins = ($diff->format("%a") * 24) + ($diff->format("%h") * 60) + $diff->format("%i");
            $textarea = ($diff_mins > 10) ? true : false;
            $last_updated_string = $corrections[0]->time;
            //var_dump($diff_mins);

            return view('acknowledgement')
                    ->with('corrections', $corrections)
                    ->with('last_update', $last_updated_string)
                    ->with('show_textarea', $textarea)
                    ->with('device', $device)
                    ->with('device_array', $device_array);

        }
        else{
            return view('acknowledgement')
                ->with('corrections', $corrections)
                ->with('last_update', '00:00')
                ->with('show_textarea', true)
                ->with('device', $device)
                ->with('device_array', $device_array);

        }




    }

    public function postAcknowledgement(){
        date_default_timezone_set("Europe/London");

        $correction_text = Input::get('correction');
        $device_id = Input::get('device_id');
        $reading = Input::get('reading');
        $min_threshold = Input::get('min_threshold');
        $max_threshold = Input::get('max_threshold');
        $day = date("Y-m-d");
        $time = date("H:i");
        $device = Device::where('sensor_id', '=', floatval($device_id))->first();
        $correction = new Correction([
            'device_id'     =>  $device->id,
            'user_id'       =>  auth::user()->id,
            'user_name'     =>  auth::user()->name,
            'correction'    =>  $correction_text,
            'time'          =>  $time,
            'date'          =>  $day,
            'val'           =>  $reading,
            'min'           =>  $min_threshold,
            'max'           =>  $max_threshold,
        ]);

        $global = $correction->save() ? 0 : 1;
        return redirect()->back()
            ->with('global', $global);





    }





}
