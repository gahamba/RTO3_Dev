<?php

namespace App\Http\Controllers;

use App\Company;
use App\Datapoint;
use App\DatasetMap;
use App\Device;
use App\MongoSensorData;
use App\MongoSystem;
use App\Reading;
use App\SensorData;
use App\SensorData_SensorData;
use App\SensorMap;
use App\User;
use App\UserDeviceMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use DateTime;
use MongoDB\BSON\UTCDateTime;

class DeviceController extends Controller
{
    /**
     * Index fetches all the companies from the database and sends to the company view
     * @return landing page for companies
     */
    public function landing(){
        $devices = Device::where('company_id', '=', auth::user()->company_id)->get();
        return view('device')
            ->with('devices', $devices);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try{
            if(auth::user()->company_id == -1){
                if(auth::user()->user_type == 0){
                    $devices = Device::where('user_id', '=', auth::user()->id)
                        ->orderBy('id', 'DESC')->get();
                }
                else{
                    $devicemaps = UserDeviceMap::where('user_id', '=', auth::user()->id)->pluck('device_id');
                    $devices = Device::whereIn('id', $devicemaps)
                        ->orderBy('id', 'DESC')->get();
                }

            }
            else{
                if(auth::user()->user_type == 0){
                    $devices = Device::where('company_id', '=', auth::user()->company_id)
                        ->orderBy('id', 'DESC')->get();
                }
                else{
                    $devicemaps = UserDeviceMap::where('user_id', '=', auth::user()->id)->pluck('device_id');
                    $devices = Device::whereIn('_id', $devicemaps)
                                        ->orderBy('id', 'DESC')->get();

                }

            }

            $devs = array();
            foreach($devices as $device){

                $datapoints = array(); $points = array(); $f_datapoints = []; $e_datapoints = [];
                $datapoints = Datapoint::whereIn('interface', $device->data_channels)->get();
                //$datapoints = collect($datapoints);

                foreach ($device->data_points as $dpoint){
                    $points[] = $dpoint['point'];

                }
                $existing_datapoints = $datapoints->whereIn('interface', $points);
                $free_datapoints = $datapoints->whereNotIn('interface', $points);

                foreach($existing_datapoints as $ed){
                    array_push($e_datapoints, $ed);
                }

                foreach($free_datapoints as $fd){
                    array_push($f_datapoints, $fd);
                }

                //echo $existing_datapoints.'<br /><br />';
                //echo $free_datapoints.'<br /><br />';
                //echo $datapoints.'<br /><br />';

                array_push($devs,
                    array(
                        'id'            =>  $device->id,
                        'name'          =>  $device->name,
                        'unique_id'     =>  $device->unique_id,
                        'min_threshold' =>  $device->min_threshold,
                        'max_threshold' =>  $device->max_threshold,
                        'description'   =>  $device->description,
                        'created_by'    =>  User::find($device->created_by)->name,
                        'data_points'   =>  $datapoints,
                        'added_datapoints'  =>  $device->data_points, /*existing datapoints in react*/
                        'removed_datapoints' => $e_datapoints, /*existing datapoints in react but removed from drop down list*/
                        'datapoints'    =>  $f_datapoints, /*not existing datapoints in react, acailable in dropdown*/
                        'data_channels' =>  $device->data_channels,

                    )
                );
            }
            return response()->json($devs);
            
        }
        catch(\Exception $ex){
            return response()->json($ex);
        }




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
        try{
            $name = $request->get('name');
            $unique_id = $request->get('unique_id');
            $system_id = $request->get('system_id');
            $system_name = $request->get('system_name');
            $data_points = $request->get('data_points');
            $description = $request->get('description');
            $user_id = auth::user()->company_id == -1 ? auth::user()->id : 0;
            /*$this_device = Device::where('unique_id', '=', $unique_id)
                                ->orWhere(function ($query) use ($name) {
                                    $query->where('name', '=', $name)
                                            ->where('company_id', '=', auth::user()->company_id)
                                            ->where('user_id', '=', auth::user()->id);
                                })->first();*/
            $this_device = Device::where('sensor_id', '=', floatval($unique_id))->first();

            $msg = 'Sorry, we cannot add device at this time, please try again';
            if(!$this_device){
                $msg = 'Device name or unique id already exists';
            }
            else{
                foreach($data_points as &$datapoint){
                    $date = DateTime::createFromFormat( 'Y-m-d\TH:i:s.uT', date('Y-m-d\TH:i:s.uT'));
                    $datapoint['threshold_active_date'] = new UTCDateTime($date->format('U') * 1000);
                    $datapoint['start_delay'] = new UTCDateTime($date->format('U') * 1000);
                    $datapoint['end_delay'] = new UTCDateTime($date->format('U') * 1000);

                }

                $this_device->system_id = '0';
                $this_device->system_name = $system_name;
                $this_device->data_points = $data_points;
                $this_device->sensor_name = $name;
                $this_device->company_id = auth::user()->company_id;
                $this_device->name = $name;
                $this_device->unique_id = $unique_id;
                $this_device->user_id = $user_id;
                $this_device->description = $description;
                $this_device->created_by = auth::user()->id;
                $this_device->activated = 1;
                if($this_device->save()){

                    $msg = 'Successfully added';
                }
                else{
                    $msg = 'We could not complete that action.';
                }


            }
            return response()->json($msg);

        }
        catch(Exception $ex){
            $msg = substr($ex, 0, 10);
            return response()->json($msg);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        //echo $request;

        $name = $request->get('name');
        $unique_id = $request->get('unique_id');
        $system_id = $request->get('system_id');
        $system_name = $request->get('system_name');
        $data_points = $request->get('data_points');
        $description = $request->get('description');
        $user_id = auth::user()->company_id == -1 ? auth::user()->id : 0;
        /*$this_device = Device::where('unique_id', '=', $unique_id)
                            ->orWhere(function ($query) use ($name) {
                                $query->where('name', '=', $name)
                                        ->where('company_id', '=', auth::user()->company_id)
                                        ->where('user_id', '=', auth::user()->id);
                            })->first();*/
        $this_device = Device::where('sensor_id', '=', floatval($unique_id))->first();
        $d = '';

        $msg = 'Sorry, we cannot find device at this time, please try again';
        if(!$this_device){
            $msg = 'Device name or unique id not fount at this time. Please refresh page and retry.';
        }
        else {
            foreach ($data_points as &$datapoint) {
                $collection = collect($this_device->data_points);
                $dpoint = $collection->firstWhere('point', '=', $datapoint['point']);
                //var_dump($dpoint);
                if ($dpoint) {
                    //var_dump($dpoint['threshold_active_date']['$date']['$numberLong']);
                    //var_dump((new UTCDateTime($datapoint['threshold_active_date']['$date']['$numberLong']))->toDateTime()->format('r'));
                    //$date = DateTime::createFromFormat('Y-m-d\TH:i:s.uT', intval($dpoint['threshold_active_date']['$date']['$numberLong']));
                    //$olddate = (new UTCDateTime($datapoint['threshold_active_date']['$date']['$numberLong']))->format('U')->toDateTime();
                    $date = DateTime::createFromFormat('Y-m-d\TH:i:s.uT', date('Y-m-d\TH:i:s.uT'));
                    //$datapoint['threshold_active_date'] = new UTCDateTime($olddate * 1000);
                    $datapoint['threshold_active_date'] = new UTCDateTime($date->format('U') * 1000);
                    $datapoint['start_delay'] = new UTCDateTime($date->format('U') * 1000);
                    $datapoint['end_delay'] = new UTCDateTime($date->format('U') * 1000);

                } else {
                    $date = DateTime::createFromFormat('Y-m-d\TH:i:s.uT', date('Y-m-d\TH:i:s.uT'));
                    $datapoint['threshold_active_date'] = new UTCDateTime($date->format('U') * 1000);
                    $datapoint['start_delay'] = new UTCDateTime($date->format('U') * 1000);
                    $datapoint['end_delay'] = new UTCDateTime($date->format('U') * 1000);

                }



            }

            $this_device->system_id = '0';
            $this_device->system_name = $system_name;
            $this_device->data_points = $data_points;
            $this_device->sensor_name = $name;
            $this_device->company_id = auth::user()->company_id;
            $this_device->name = $name;
            $this_device->unique_id = $unique_id;
            $this_device->user_id = $user_id;
            $this_device->description = $description;
            $this_device->created_by = auth::user()->id;
            $this_device->activated = 1;
            if ($this_device->save()) {

                $msg = 'Successfully Updated';
            } else {
                $msg = 'We could not complete that action.';
            }

            return response()->json($msg);
            /*try{

                $device->save();
                return response()->json('Successfully Updated');
            }
            catch (\Exception $ex){
                return response()->json($ex);
            }*/


        }






        /*if(!$request->get('company_id')){
            $device = Device::find($device->id);
            $device->name = $request->get('name');
            $device->min_threshold = $request->get('min_threshold');
            $device->max_threshold = $request->get('max_threshold');
            $device->description = $request->get('description');
            $device->created_by = auth::user()->id;

            try{
                $exists = Device::where('_id', '!=', $device->id)
                                ->where(function($query) use ($request){
                                    $query->where('unique_id', '=', $request->get('unique_id'))
                                        ->orWhere(function ($query2) use ($request) {
                                            $query2->where('name', '=', $request->get('name'))
                                                ->where(function($query3){
                                                    $query3->where('user_id', '=', auth::user()->id)
                                                        ->orWhere(function($query4){
                                                            $query4->where('company_id', '=', auth::user()->company_id)
                                                                ->where('company_id', '!=', -1);
                                                        });
                                                });


                                        });
                                })->get();



                if(count($exists) < 1){

                    $device->save();


                    $this_system = MongoSensorData::where('sensor_id', '=', floatval($device->unique_id))->first();
                    if($this_system){
                        $system_id = $this_system->system_id;
                        $system = MongoSystem::where('id', '=', $system_id)->first();*/

                        /*$sensors = $system->sensors;

                        foreach($sensors as $key => $sensor){

                            if($sensor['id'] == floatval($device->unique_id)){

                                foreach($sensor['dataPoints'] as $d_key => $datapoint){

                                    if($datapoint['lable'] == "temp1"){

                                        $date = new DateTime(date("Y-m-d H:i:s.u"));

                                        $sensors[$key]['dataPoints'][$d_key]['minT'] = floatval($request->get('min_threshold'));
                                        $sensors[$key]['dataPoints'][$d_key]['maxT'] = floatval($request->get('max_threshold'));
                                        $sensors[$key]['dataPoints'][$d_key]['activeDate'] = $date->format(DateTime::ATOM);

                                    }

                                }

                            }


                        }
                        $system->sensors = $sensors;
                        $system->save();*/
                    /*}



                    return response()->json('Successfully Updated');
                }
                else{
                    return response()->json('Device with the same name or ID already exists');
                }

            }
            catch (\Exception $ex){
                echo $ex;
                //return response()->json($ex);
            }
        }
        else{
            $device = Device::where('unique_id', '=', $request->get('unique_id'))->first();
            $device->company_id = $request->get('company_id');
            try{

                $device->save();
                return response()->json('Successfully Updated');
            }
            catch (\Exception $ex){
                return response()->json($ex);
            }
        }*/




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        try{
            $device = Device::find($device->id);
            //$reading = Reading::where('unique_id', '=', $device->unique_id)->first();
            //$reading->delete();
            $device->activated = 0;
            $device->user_id = 0;
            $device->company_id = '';
            $device->save();


            return response()->json('Successfully Deleted');
        }
        catch(\Exception $ex){
            return response()->json($ex);
        }

    }

    /**
     * Fetch number of devices.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function countDevices()
    {


        if(auth::user()->company_id == -1){
            //$devices_count = count(Device::where('user_id', '=', auth::user()->id)->get());
            if(auth::user()->user_type == 0){
                $devices_count = count(Device::where('user_id', '=', auth::user()->id)->get());
            }
            else{
                $devicemaps = UserDeviceMap::where('user_id', '=', auth::user()->id)->get('device_id');
                $devices_count = count(Device::whereIn('id', $devicemaps)->get());
            }



        }
        else{

            if(auth::user()->user_type == 0){
                $devices_count = count(Device::where('company_id', '=', auth::user()->company_id)->get());
            }
            else{
                $devicemaps = UserDeviceMap::where('user_id', '=', auth::user()->id)->get('device_id');
                $devices_count = count(Device::whereIn('id', $devicemaps)->get());


            }
        }

        $perfect = 0.8 * 100;
        $attention = 0.2 * 100;
        $bad = 0.1 * 100;

        return response()->json(['total' => $devices_count, 'perfect' => $perfect, 'attention' => $attention, 'bad' => $bad]);

    }

    /**
     * Check if Sensor Exists
     */
    public function sensorIDExists($sensor_id)
    {
        $device = Device::where('sensor_id', '=', floatval($sensor_id))->first();
        $result = $device  ? true : false;
        $datapoints = array();
        if($result){
            $datapoints = Datapoint::whereIn('interface', $device->data_channels)->get();
        }


        return response()->json(['result' => $result, 'device' => $device, 'datapoints' => $datapoints]);

    }

    /**
     * Read sensor data from sensor data table
     *
     */
    public function sensorReading($sensorId)
    {
        //date_default_timezone_set("Europe/London");
        $date = new DateTime(date("Y-m-d"));

        $today = str_replace("+",".000+", $date->format(DateTime::ATOM));
        $this_record = MongoSensorData::where('sensor_id', '=', floatval($sensorId))
                                        ->where('recordDay', '=', new DateTime($today))->first();

        $device = Device::where('sensor_id', '=', floatval($sensorId))->first();
        $datapoints = $device->data_points;
        $reading = array();
        foreach ($datapoints as $datapoint){
            if($this_record){
                if(isset($this_record->dataSamples[$this_record->nSample - 1][$datapoint['point']])){
                    $sensor_reading = round($this_record->dataSamples[$this_record->nSample - 1][$datapoint['point']], 2);
                }
                else{
                    $sensor_reading = 0;
                }

            }
            else{
                $sensor_reading = -1.00;
            }
            $reading[] = ['datapoint' => $datapoint, 'reading' => $sensor_reading];
        }

        return $reading;
    }

    /**
     * Choose value to read based on Map point
     *
     */
    public function sensorReadingMapValue($sensor)
    {
        $reading = 0;
        //echo $reading;
        $sensormap = SensorMap::where('sensorID', '=', $sensor->sensorID)->first();

        if(!$sensormap){
            $sensormap = DatasetMap::where('sensorID', '=', $sensor->sensorID)->first();
        }
        $point = $sensormap->point;
        //var_dump($sensordata);
        switch($point){
            case "temp1":
                $reading = $sensor->temp1;
                break;
            case "temp2":
                $reading = $sensor->temp2;
                break;
            case "temp3":
                $reading = $sensor->temp3;
                break;
            case "temp4":
                $reading = $sensor->temp4;
                break;
            case "temp5":
                $reading = $sensor->temp5;
                break;
        }


        return $reading;
    }


    /**
     * Fetch number of device_status with counts.
     *
     *
     */
    public function deviceStatus(){

        try{

            if(auth::user()->company_id == -1){
                if(auth::user()->user_type == 0){
                    $devices = Device::where('user_id', '=', auth::user()->id)
                        ->orderBy('unique_id', 'DESC')->get();

                }
                else{
                    $devicemaps = UserDeviceMap::where('user_id', '=', auth::user()->id)->get('device_id');
                    $devices = Device::whereIn('id', $devicemaps)
                        ->orderBy('unique_id', 'DESC')->get();
                }

            }
            else{
                if(auth::user()->user_type == 0){
                    $devices = Device::where('company_id', '=', auth::user()->company_id)
                        ->orderBy('unique_id', 'DESC')->get();

                }
                else{
                    $devicemaps = UserDeviceMap::where('user_id', '=', auth::user()->id)->pluck('device_id');


                        $devices = Device::whereIn('_id', $devicemaps)
                            ->orderBy('unique_id', 'DESC')->get();





                }

            }


            $devices_count = count($devices);
            $perfect = 0;
            $attention = 0;
            $bad = 0;
            $dev_stat = array();
            //var_dump($devices_count);
            $message = new MessageController();
            foreach($devices as $device){

                //$readflag = 0;
                $readvals = $this->sensorReading($device->unique_id);
                $stats = array();
                $this_reading = array();
                $bad_exists = false; $attention_exists = false; $perfect_exists = false;


                foreach($readvals as $readval){

                    if($readval['reading'] > $readval['datapoint']['maxT'] || $readval['reading'] < $readval['datapoint']['minT']){
                        $bad_exists = true;
                        $message->newMessage($device, $readval['reading'], "Critical");
                        array_push($this_reading,
                            array(
                                'unique_id' => $device->unique_id,
                                'notifier'  => 'danger',
                                'status'    =>  -1,
                                'comment'   =>  1,
                                'message'   =>  'Critical',
                                'datapoint' =>  Datapoint::where('interface', '=', $readval['datapoint']['point'])->first()->default_name,
                                'interface' =>  $readval['datapoint']['point'],
                                'val'       =>  $readval['reading'],
                                'min_threshold' => $readval['datapoint']['minT'],
                                'max_threshold' => $readval['datapoint']['maxT']

                            )

                        );

                    }

                    elseif ($readval['reading'] == $readval['datapoint']['maxT'] || $readval['reading'] == $readval['datapoint']['minT']){
                        $attention_exists = true;
                        $message->newMessage($device, $readval['reading'], "Attention");

                        array_push($this_reading,
                            array(
                                'unique_id' => $device->unique_id,
                                'notifier'  => 'warning',
                                'status'    =>  0,
                                'comment'   =>  0,
                                'message'   =>  'Attention',
                                'datapoint' =>  Datapoint::where('interface', '=', $readval['datapoint']['point'])->first()->default_name,
                                'interface' =>  $readval['datapoint']['point'],
                                'val'       =>  $readval['reading'],
                                'min_threshold' => $readval['datapoint']['minT'],
                                'max_threshold' => $readval['datapoint']['maxT']

                            )

                        );


                    }

                    else{
                        $perfect_exists = true;
                        array_push($this_reading,
                            array(
                                'unique_id' => $device->unique_id,
                                'notifier'  => 'success',
                                'status'    =>  1,
                                'comment'   =>  0,
                                'message'   =>  'Perfect',
                                'datapoint' =>  Datapoint::where('interface', '=', $readval['datapoint']['point'])->first()->default_name,
                                'interface' =>  $readval['datapoint']['point'],
                                'val'       =>  $readval['reading'],
                                'min_threshold' => $readval['datapoint']['minT'],
                                'max_threshold' => $readval['datapoint']['maxT']

                            )

                        );
                    }
                }

                array_push($dev_stat,
                    array(
                        'name'      =>  $device->name,
                        'device_id' =>  $device->id,
                        'unique_id' =>  $device->unique_id,
                        'datapoints' =>  $this_reading

                    )
                );

                if($bad_exists){
                    $bad += 1;
                }
                else{
                    if($attention_exists){
                        $attention += 1;
                    }
                    else{
                        $perfect += 1;
                    }
                }

            }

            $counts = array(
                'total'     =>  $devices_count,
                'bad'       =>  $bad,
                'attention' =>  $attention,
                'perfect'   =>  $perfect,
            );


            return response()->json(['dev_stats' => $dev_stat, 'counts' => $counts]);

        }
        catch(\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * Read recent sensor readings from sensorData tables
     *
     */
    public function sensorRecentReadings($sensorId, $datapoint)
    {
        $sensorDetail = Device::where('unique_id', '=', floatval($sensorId))->first();
        foreach($sensorDetail->data_points as $data_point){
            if($data_point['point'] == $datapoint){
                $minT = $data_point['minT'];
                $maxT = $data_point['maxT'];
            }
        }
        $reading = 0;
        //date_default_timezone_set("Europe/London");
        $date = new DateTime(date("Y-m-d"));
        $sensordataToday = array();
        $today = str_replace("+",".000+", $date->format(DateTime::ATOM));
        $this_record = MongoSensorData::where('sensor_id', '=', floatval($sensorId))
                                    ->where('recordDay', '=', new DateTime($today))->first();

        if($this_record){
            $sensorDs = $this_record->dataSamples;
            for (end($sensorDs); key($sensorDs)!==null; prev($sensorDs)){
                $sensordata = current($sensorDs);
                // ...
                if(isset($sensordata[$datapoint])){
                    $reading = $sensordata[$datapoint];
                    //var_dump($reading);

                    if($sensordata[$datapoint.'-minV'] == 1 || $sensordata[$datapoint.'-maxV'] == 1){
                        $status = 'danger';
                    }
                    elseif($sensordata[$datapoint.'-minV'] == -1 || $sensordata[$datapoint.'-maxV'] == -1){
                        $status = 'warning';
                    }
                    else{
                        $status = 'success';
                    }

                    $min_T = $sensordata[$datapoint.'-minT'];
                    $max_T = $sensordata[$datapoint.'-maxT'];
                }
                else{
                    $reading = 0;
                    $status = 'danger';
                    $min_T = 0;
                    $max_T = 0;
                }
                //var_dump($status);
                array_push($sensordataToday,
                    array(
                        'sensorName'    =>  $sensorDetail->name,
                        'sensorID'      =>  $sensorId,
                        'dateTime'      =>  $sensordata['recordDate']->toDateTime()->format('Y-m-d H:i:s'),
                        'reading'       =>  round($reading, 2),
                        'status'        =>  $status,
                        'min_threshold' =>  $min_T,
                        'max_threshold' =>  $max_T,
                        'n_min_violation'   =>  0,
                        'n_max_violation'   =>  0,

                    )
                );

                if(key($sensorDs) == count($sensorDs) - 10)
                    break;
            }
        }
        else{

            array_push($sensordataToday,
                array(
                    'sensorName'    =>  $sensorDetail->name,
                    'sensorID'      =>  $sensorId,
                    'dateTime'      =>  date('Y-m-d H:i:s'),
                    'reading'       =>  round($reading, 2),
                    'status'        =>  'danger',
                    'min_threshold' =>  isset($minT) ? $minT : 0,
                    'max_threshold' =>  isset($maxT) ? $maxT : 0,
                    'n_min_violation'   =>  0,
                    'n_max_violation'   =>  0,

                )
            );
        }







        $sensordataRecents = array();

        $sensorDRs = MongoSensorData::where('sensor_id', '=', floatval($sensorId))
                                            ->orderBy('recordDay', 'DESC')->take(10)->get();


        foreach($sensorDRs as $sensordata){
            $reading = $sensordata->$datapoint['average'];
            if($reading < $minT || $reading > $maxT){
                $status = 'danger';
            }
            elseif($reading == $minT || $reading == $maxT){
                $status = 'warning';
            }
            else{
                $status = 'success';
            }
            //var_dump(date_format(new DateTime($sensordata->recordDay), 'd-m-Y H:i:s'));
            //var_dump($sensordata->maxTime);
            //var_dump(date_format($sensordata->recordDay->toDateTime(), 'Y-m-d'));
            array_push($sensordataRecents,
                array(
                    'sensorName'    =>  $sensorDetail->name,
                    'sensorID'      =>  $sensordata->sensorId,
                    'dateTime'      =>  date_format($sensordata->recordDay->toDateTime(), 'Y-m-d H:i:s'),
                    'reading'       =>  round($reading, 2),
                    'status'        =>  $status,
                    'min_threshold' =>  $minT,
                    'max_threshold' =>  $maxT,
                    'n_min_violation'   =>  $sensordata->$datapoint['n-minV'],
                    'n_max_violation'   =>  $sensordata->$datapoint['n-maxV'],

                )
            );
            //var_dump($sensordataRecents);

        }




        return response()->json(['today' => $sensordataToday, 'recents' => $sensordataRecents, 'reading' => $reading]);
    }

    /**
     * Fetch specified device by uniqueId from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function deviceByUniqueId($unique_id)
    {
        $device = Device::where('unique_id', '=', $unique_id)->first();
        if($device){
            if($device->company_id == 0){
                return response()->json(['device' => $device, 'isFree' => 1, 'msg' => 'Add '.$device->name.' to company?']);
            }
            else{
                return response()->json(['device' => '', 'isFree' => 0, 'msg' => $device->name.' is already assigned to another company']);
            }
        }
        else{
            return response()->json(['device' => '', 'isFree' => -1, 'msg' => 'Device not found']);
        }

    }



    /**
     * Update the specified record with companyId in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function updateWithCompanyId(Request $request)
    {
        $device = Device::where('unique_id', '=', $request->get('unique_id'))->first();

        $msg = "";
        if(!$device){
            $msg = "Sorry! This device does not exist";
        }
        else if($device->company_id != 0){
            $msg = "Sorry! This device does not belong to you";
        }
        else{
            $device->company_id = $request->get('company_id');



            $device->created_by = auth::user()->id;

            try{

                $device->save();
                $msg = "Successfully Added";

            }
            catch (\Exception $ex){
                $msg = $ex;
            }
        }
        return response()->json($msg);



    }
}
