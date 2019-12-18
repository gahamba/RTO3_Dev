<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Exports\HacpExport;
use App\MongoSensorData;
use DateTime;
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
        if($config){
            return view('reports')
                    ->with('config', $config);
        }
        else{
            return view('reports');
        }

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

        $configuration = Configuration::where('companyId', '=', auth::user()->company_id)->first()->times;
        if(!$configuration){
            $configuration = ['0', '12', '16', '22'];
        }
        $arrayToReturn = array();
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

                array_push($arrayToReturn, array(
                    '_id' => $reading->id,
                    'recordDay' => $timestamp,
                    'sensorId' => $device,
                    'points'    =>  $points,
                    'dataSamples' => $sample_array
                ));
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
        $readingstosend = $this->returnHourlyArray($readings, $ps, $device);
        /*$configuration = Configuration::where('companyId', '=', auth::user()->company_id)->first()->times;
        if(!$configuration){
            $configuration = array(0 => "0", 1 => "12", 2 => "16", 3 => "22");
        }
        foreach($readings as $reading){

            foreach($configuration as $config){
                $sample = $reading->dataSamples->firstWhere('hour', $config);
                array_push($readingstosend, array(
                    'recordDay' => $reading->recordDay,
                    'sensorId'  => $reading->sensorId,
                    'dataSamples'   =>  $sample
                ));
            }

        }*/
        /*$collection = collect($readings);
        $collection->map(function($readings){

        });*/




        return $readingstosend;

    }

    /**
     * Get reports based on dates selected
     */
    public function getNewReports($from, $to, $reportType, $device){

        $configuration = Configuration::where('companyId', '=', auth::user()->company_id)->first()->times;
        if(!$configuration){
            $configuration = ['0', '12', '16', '22'];
        }
        $readings = $this->getReportReadings($from, $to, $reportType, $device);



        return response()->json(array('readings' => $readings, 'configuration'  =>  $configuration ));

    }
    public function exportReport($from, $to, $reportType, $device, $interface)
    {
        $readings = $this->getReportReadings($from, $to, $reportType, $device);
        //var_dump($readings[0]['dataSamples'][0]['recordDate']);
        return Excel::download(new HacpExport($readings, $interface), 'hacp.xlsx');
    }
}
