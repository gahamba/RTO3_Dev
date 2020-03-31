<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Exports\HacpExport;
use App\MongoSensorData;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Device;
use MongoDB\BSON\UTCDateTime;

class ReportsController extends Controller
{
    /**
     * Landing Page
     *
     */
    public function landing()
    {
        $config = Configuration::where('companyId', '=', auth::user()->company_id)->first();
        if(!($config && is_array($config->times) && count($config->times) > 0)){
            $config = new Configuration();
            $config->times = ['0', '12', '16', '22'];
        }
        return view('reports')
            ->with('config', $config);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Collect array from reports on hours
     *
     */
    public function returnHourlyArray($readings, $points, $device){

        $configuration = Configuration::where('companyId', '=', auth::user()->company_id)->first();
        if($configuration && $configuration->times !== null){
           $configuration = $configuration->times;
        }
        else{
            $configuration = ['0', '12', '16', '22'];
        }
        $arrayToReturn = array();
        $this_reading = 0;


        foreach($readings as $reading){

                $sample_array = array();
                for($j=0; $j<count($configuration); $j++){
                    foreach($reading->dataSamples as $sample) {
                        if ($sample['hour'] == intval($configuration[$j])) {

                            /*array_push($sample_array, array(
                                $sample
                            ));*/
                            $sample_array[] = $sample;

                            break;

                        }
                    }

                    continue;

                }

                //$record_day = (new UTCDateTime($reading['recordDay']['$date']['$numberLong']))->toDateTime()->format('U');;
                //$date = DateTime::createFromFormat('Y-m-d\TH:i:s.uT', strtotime($record_day));

                if(count($sample_array) < count($configuration)){
                    for($m = count($sample_array); $m < count($configuration); $m++){
                        $sample = array(
                            'gatewayID'           =>  '',
                            'hour'                =>  $configuration[$m],
                            'Battery'             =>  0,
                            'RSSI'                =>  0,
                            'LQI'                 =>  0,
                            'temp1'               =>  0,
                            'temp3'               =>  0,
                            'temp2'               =>  0,
                            'temp1-minV'          =>  -1,
                            'temp1-maxV'          =>  -1,
                            'temp1-minT'          =>  0,
                            'temp1-maxT'          =>  0,
                            'temp1-activeDate'    =>  '',
                            'temp1-alarmDelay'    =>  '',
                            'temp1-alarmActiveDate'   =>  '',
                            'temp3-minV'          =>  -1,
                            'temp3-maxV'          =>  -1,
                            'temp3-minT'          =>  0,
                            'temp3-maxT'          =>  0,
                            'temp3-activeDate'    =>  '',
                            'temp3-alarmDelay'    =>  '',
                            'temp3-alarmActiveDate'   =>  '',
                            'temp2-minV'          =>  -1,
                            'temp2-maxV'          =>  -1,
                            'temp2-minT'          =>  0,
                            'temp2-maxT'          =>  0,
                            'temp2-activeDate'    =>  '',
                            'temp2-alarmDelay'    =>  '',
                            'temp2-alarmActiveDate'   =>  '',
                            'system_id'           =>  0,

                        );

                        $sample_array[$m] = $sample;
                    }
                }
                $timestamp = (new DateController())->convertMongoToY_M_D($reading->recordDay);

                //if($this_reading != $reading->sensor_id){
                    array_push($arrayToReturn, array(
                        '_id' => $reading->id,
                        'recordDay' => $timestamp,
                        'sensorId' => $device,
                        'sensor_id' =>  $reading->sensor_id,
                        'sensor_name'   => Device::where('sensor_id', '=', $reading->sensor_id)->first()->sensor_name,
                        'points'    =>  $points,
                        'dataSamples' => $sample_array
                    ));
               //}
                //$this_reading = $reading->sensor_id;

                /*foreach($configuration as $config){
                    if($sample['hour'] == intval($config)){

                        array_push($arrayToReturn, array(
                            '_id' =>    $reading->id,
                            'recordDay' => $reading->recordDay,
                            'sensorId'  => $reading->sensorId,
                            'dataSamples'   =>  [$sample]
                        ));
                    }
                    continue;
                }*/

        }

        return $arrayToReturn;

    }

    /**
     *
     * function to return readings based on dates
     */
    public function getReportReadings($from, $to, $reportType, $device){
        $from = $from;
        $to = $to;
        $reportType = $reportType;
        $device = $device;

        /*$d_from = new DateTime($from." 00:00:00");
        $d_to = new DateTime($from." 23:59:59");

        $dfrom = new UTCDateTime($d_from->format('U') * 1000);
        $dto = new UTCDateTime($d_to->format('U') * 1000);*/

        $dateobj = new DateController();

        if($device == '*'){
            $routinecountroller = new RoutineController();
            $devices = $routinecountroller->fetchDevices();

            //$readings = new Collection();
            $readingstosend = array();
            $datapoint_count = array();
            foreach($devices as $device){

                $readings = MongoSensorData::where('minTime', '>=', $dateobj->convertY_M_DToMongoISO_Start($from))
                    ->where('maxTime', '<=', $dateobj->convertY_M_DToMongoISO_End($to))
                    ->where('sensor_id', '=', floatval($device->sensor_id))
                    ->orderBy('maxTime', 'ASC')->get();
                //$readings = $readings->merge($readings_);

                $datapoints = $device->data_points;
                $ps = array();
                foreach($datapoints as $datapoint){

                    $ps[] = $datapoint['point'];
                }

                $readingstosend[] = $this->returnHourlyArray($readings, $ps, $device);
                $datapoint_count[] = count($ps);


            }

        }
        else{
            $readings = MongoSensorData::where('minTime', '>=', $dateobj->convertY_M_DToMongoISO_Start($from))
                ->where('maxTime', '<=', $dateobj->convertY_M_DToMongoISO_End($to))
                ->where('sensor_id', '=', floatval($device))
                ->orderBy('maxTime', 'ASC')->get();

            $datapoints = Device::where('sensor_id', '=', floatval($device))->first()->data_points;
            $ps = array();
            foreach($datapoints as $datapoint){

                $ps[] = $datapoint['point'];
            }
            $readingstosend = array();
            $datapoint_count = array();
            $readingstosend[] = $this->returnHourlyArray($readings, $ps, $device);
            $datapoint_count[] = count($ps);
        }

        $reportReading = array();
        $reportReading[0] = $readingstosend;
        $reportReading[1] = $datapoint_count;


        return $reportReading;

    }

    /**
     * Get reports based on dates selected
    */
    public function getNewReports($from, $to, $reportType, $device){

        $configuration = Configuration::where('companyId', '=', auth::user()->company_id)->first();
        if(!($configuration && is_array($configuration->times))){
            $configuration = ['0', '12', '16', '22'];
        }
        else{
            $configuration = $configuration->times;
        }
        $readings = $this->getReportReadings($from, $to, $reportType, $device);

        //var_dump($readings[0]);
        $period = new \DatePeriod(new DateTime($from), new \DateInterval('P1D'), new DateTime($to));
        $dates = array();
        foreach ($period as $date) {
            $dates[] = $date->format("Y-m-d");
        }
        $dates[] = $to;

        $reading = array();
        $read_array = collect($readings[0]);
        foreach($dates as $date){
            $i = 0;
            foreach($readings[0] as $read){
                $read_array = collect($read);
                $exist = $read_array->where('recordDay', $date)->first();
                if($exist){
                    $reading[$i][] = $exist;
                }
                else{
                    $sample_array = array();
                    for($m = 0; $m < count($configuration); $m++){
                        $sample = array(
                            'gatewayID'           =>  '',
                            'hour'                =>  $configuration[$m],
                            'Battery'             =>  0,
                            'RSSI'                =>  0,
                            'LQI'                 =>  0,
                            'temp1'               =>  0,
                            'temp3'               =>  0,
                            'temp2'               =>  0,
                            'temp1-minV'          =>  -1,
                            'temp1-maxV'          =>  -1,
                            'temp1-minT'          =>  0,
                            'temp1-maxT'          =>  0,
                            'temp1-activeDate'    =>  '',
                            'temp1-alarmDelay'    =>  '',
                            'temp1-alarmActiveDate'   =>  '',
                            'temp3-minV'          =>  -1,
                            'temp3-maxV'          =>  -1,
                            'temp3-minT'          =>  0,
                            'temp3-maxT'          =>  0,
                            'temp3-activeDate'    =>  '',
                            'temp3-alarmDelay'    =>  '',
                            'temp3-alarmActiveDate'   =>  '',
                            'temp2-minV'          =>  -1,
                            'temp2-maxV'          =>  -1,
                            'temp2-minT'          =>  0,
                            'temp2-maxT'          =>  0,
                            'temp2-activeDate'    =>  '',
                            'temp2-alarmDelay'    =>  '',
                            'temp2-alarmActiveDate'   =>  '',
                            'system_id'           =>  0,

                        );

                        $sample_array[$m] = $sample;
                    }


                    $reading[$i][] = array(
                        '_id' => $device,
                        'recordDay' => $date,
                        'sensorId' => $device,
                        'sensor_id' =>  isset($read[0]) ? $read[0]['sensor_id'] : "",
                        'sensor_name'   =>  isset($read[0]) ? $read[0]['sensor_name'] : "",
                        'points'    =>  ['temp1'],
                        'dataSamples' => $sample_array
                    );
                }
                $i++;
            }

        }

        return response()->json(array('readings' => $reading, 'count_device' => $readings[1], 'configuration'  =>  $configuration, 'dates' => $dates ));

    }
    public function exportReport($from, $to, $reportType, $device)
    {
        $configuration = Configuration::where('companyId', '=', auth::user()->company_id)->first();
        if(!($configuration && is_array($configuration->times))){
            $configuration = ['0', '12', '16', '22'];
        }
        else{
            $configuration = $configuration->times;
        }
        $readings = $this->getReportReadings($from, $to, $reportType, $device);
        //var_dump($readings[0]['dataSamples'][0]['recordDate']);

        $period = new \DatePeriod(new DateTime($from), new \DateInterval('P1D'), new DateTime($to));
        $dates = array();
        foreach ($period as $date) {
            $dates[] = $date->format("Y-m-d");
        }
        $dates[] = $to;

        $reading = array();
        $read_array = collect($readings[0]);
        foreach($dates as $date){
            $i = 0;
            foreach($readings[0] as $read){
                $read_array = collect($read);
                $exist = $read_array->where('recordDay', $date)->first();
                if($exist){
                    $reading[$i][] = $exist;
                }
                else{
                    $sample_array = array();
                    for($m = 0; $m < count($configuration); $m++){
                        $sample = array(
                            'gatewayID'           =>  '',
                            'hour'                =>  $configuration[$m],
                            'Battery'             =>  0,
                            'RSSI'                =>  0,
                            'LQI'                 =>  0,
                            'temp1'               =>  0,
                            'temp3'               =>  0,
                            'temp2'               =>  0,
                            'temp1-minV'          =>  -1,
                            'temp1-maxV'          =>  -1,
                            'temp1-minT'          =>  0,
                            'temp1-maxT'          =>  0,
                            'temp1-activeDate'    =>  '',
                            'temp1-alarmDelay'    =>  '',
                            'temp1-alarmActiveDate'   =>  '',
                            'temp3-minV'          =>  -1,
                            'temp3-maxV'          =>  -1,
                            'temp3-minT'          =>  0,
                            'temp3-maxT'          =>  0,
                            'temp3-activeDate'    =>  '',
                            'temp3-alarmDelay'    =>  '',
                            'temp3-alarmActiveDate'   =>  '',
                            'temp2-minV'          =>  -1,
                            'temp2-maxV'          =>  -1,
                            'temp2-minT'          =>  0,
                            'temp2-maxT'          =>  0,
                            'temp2-activeDate'    =>  '',
                            'temp2-alarmDelay'    =>  '',
                            'temp2-alarmActiveDate'   =>  '',
                            'system_id'           =>  0,

                        );

                        $sample_array[$m] = $sample;
                    }


                    $reading[$i][] = array(
                        '_id' => $device,
                        'recordDay' => $date,
                        'sensorId' => $device,
                        'sensor_id' =>  $read[0]['sensor_id'],
                        'sensor_name'   =>  $read[0]['sensor_name'],
                        'points'    =>  ['temp1'],
                        'dataSamples' => $sample_array
                    );
                }
                $i++;
            }

        }
        return Excel::download(new HacpExport($reading, $readings[1], $configuration, $dates), 'hacp.xlsx');
    }
}
