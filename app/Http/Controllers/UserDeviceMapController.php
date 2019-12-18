<?php

namespace App\Http\Controllers;

use App\Device;
use App\Reading;
use App\User;
use App\UserDeviceMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class UserDeviceMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userdevicemap = UserDeviceMap::all();
        return response()->json($userdevicemap);
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
        try{
            $user_id = $request->get('user_id');
            $system_id = $request->get('system_id');
            $device_id = $request->get('device_id');


            $this_map = UserDeviceMap::where('user_id', '=', $user_id)
                                    ->where('device_id', '=', $device_id)->first();

            $msg = 'Sorry, we cannot add device at this time, please try again';
            if($this_map){
                $msg = 'Device name or unique id already exists';
            }
            else{
                $userdevicemap = new UserDeviceMap([
                    'user_id'          =>  $user_id,
                    'system_id'        =>  $system_id,
                    'device_id'        =>  $device_id,

                ]);
                if($userdevicemap->save()){

                    $msg = 'Successfully added '.Device::find($device_id)->name.' to '.User::find($user_id)->name;
                }


            }
            return response()->json($msg);

        }
        catch(Exception $ex){
            $msg = $ex;
            return response()->json($msg);
        }
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
        $this_map = UserDeviceMap::find($id);

        if($this_map.delete()){
            return response()->json("Successful");
        }
        else{
            return response()->json("Unable to retrieve access at this time. Please try again");
        }
    }

    /**
     * Fetch userdevice map for user
     */
    public function fetchUserDeviceMap($user_id){
        $userdevicemap = UserDeviceMapController::where('user_id', '=', auth::user()->id)->get();
        return response()->json($userdevicemap);
    }

    /**
     * Fetch Devices associated with user
     */
    public function fetchAssoc($user_id){

        try{
            $this_map = UserDeviceMap::where('user_id', '=', $user_id)->pluck('device_id')->toArray();
            if(auth::user()->company_id == -1){
                $added_devs = Device::where('user_id', '=', auth::user()->id)
                                        ->whereIn('_id', $this_map)
                                        ->orderBy('name', 'ASC')->get();
                $unadded_devs = Device::where('user_id', '=', auth::user()->id)
                                        ->whereNotIn('_id', $this_map)
                                        ->orderBy('name', 'ASC')->get();
            }
            else{
                $added_devs = Device::where('company_id', '=', auth::user()->company_id)
                                        ->whereIn('_id', $this_map)
                                        ->orderBy('name', 'ASC')->get();
                $unadded_devs = Device::where('company_id', '=', auth::user()->company_id)
                                        ->whereNotIn('_id', $this_map)
                                        ->orderBy('id', 'ASC')->get();
            }

            /*$added_devs = array();
            $unadded_devs = array();
            foreach($devices as $device){
                $this_map = UserDeviceMap::where('user_id', '=', $user_id)
                                            ->where('device_id', '=', $device->id)->first();
                if($this_map){
                    array_push($added_devs,
                        array(
                            'id'            =>  $device->id,
                            'name'          =>  $device->name,
                            'unique_id'     =>  $device->unique_id,
                            'map_id'        =>  $this_map->id,

                        )
                    );
                }
                else{
                    array_push($unadded_devs,
                        array(
                            'id'            =>  $device->id,
                            'name'          =>  $device->name,
                            'unique_id'     =>  $device->unique_id,
                            'map_id'        =>  '',

                        )
                    );
                }

            }*/
            return response()->json(['added_devices' => $added_devs, 'unadded_devices' =>  $unadded_devs]);

        }
        catch(\Exception $ex){
            return response()->json($ex);
        }

    }

    /**
     * Delete Map
     */
    public function deleteMap($device_id, $user_id){
        $this_map = UserDeviceMap::where('user_id', '=', $user_id)
            ->where('device_id', '=', $device_id);

        if($this_map->delete()){
            return response()->json("Successful");
        }
        else{
            return response()->json("Unable to retrieve access at this time. Please try again");
        }
    }
}
