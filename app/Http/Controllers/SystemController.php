<?php

namespace App\Http\Controllers;

use App\System;
use App\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SystemController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Landing page for systems
     */
    public function landing(){
        $systems = System::where('company_id', '=', auth::user()->company_id)
                            ->orderBy('created_at', 'DESC')->get();
        $devices = Device::where('company_id', '=', auth::user()->company_id)
                            ->where('system_id', '=', '0')->get();
        $oth_devices = Device::where('company_id', '=', auth::user()->company_id)
                            ->where('system_id', '!=', '0')->get();
        return view('system')
                ->with('systems', $systems)
                ->with('devices', $devices)
                ->with('assigned_devices', $oth_devices);
    }

    /**
     * Post system form and handle request
     *
     */
    public function postCreateSystem(Request $request){
        $system_name = Input::get('system_name');
        $system_location = Input::get('system_location');
        $system_description = Input::get('system_description');
        $system = System::where('company_id', '=', auth::user()->company_id)
                        ->where('system_name', '=', $system_name)->first();

        if($system){
            $global = 1;
            $message = "System already exists";
        }
        else{
            $sys = System::create(array(
                'company_id' => auth::user()->company_id,
                'system_name'           =>    $system_name,
                'system_description'    =>    $system_description,
                'system_location'       =>    $system_location,
                'system_type'           =>    0,
                'created_by'            =>    auth::user()->_id,
            ));

            if($sys){
                $global = 0;
                $message = "Successfully added System";
            }
            else{
                $global = 1;
                $message = "Unable to add at this time";
            }

        }

        return redirect()->back()
                ->with('global', $global)
                ->with('message', $message);
    }

    /**
     * Edit System post
     *
     */
    public function postUpdateSystem(){

        $system_id = Input::get('system_id');

        $system_name = Input::get('system_name');
        $system_location = Input::get('system_location');
        $system_description = Input::get('system_description');

        $system = System::find($system_id);


        $exists = System::where('_id', '!=', $system_id)
                        ->where('system_name', '=', $system_name)
                        ->where('company_id', '=', $system->company_id)->first();

        if(!$exists){
            $system->system_name = $system_name;
            $system->system_location = $system_location;
            $system->system_description = $system_description;

            if($system->save()){
                $global = 0;
                $message = "Successfully updated System-".$system_name;
            }
            else{
                $global = 1;
                $message = "Unable to update System-".$system_name." at this time. Please try again later";
            }
        }
        else{
            $global = 1;
            $message = "A system with the same system name already exists in your organization";
        }



        return redirect()->back()
            ->with('global', $global)
            ->with('message', $message);

    }

    /**
     * Delete System
     *
     */
    public function postDeleteSystem(){

        $system_id = Input::get('system_id');
        $system = System::find($system_id);
        $device_exist = Device::where('system_id', '=', $system_id)->get();
        if(count($device_exist) > 0){
            $global = 1;
            $message = "Cannot delete System-".$system->system_name." because it contains devices. Please delete devices first";
        }
        else{

            if($system->delete()){
                $global = 0;
                $message = "Successfully deleted System-".$system->system_name;
            }
            else{
                $global = 1;
                $message = "Cannot delete System-".$system->system_name." at this time, please try again later";
            }
        }

        return redirect()->back()
            ->with('global', $global)
            ->with('message', $message);

    }

    /**
     * Add or remove device from system
     *
     */
    public function postUpdateSystemDevices(){

        //$system = Input::get('system');
        $system = 0;
        $onsystem = Input::get('onsystem');
        $offsystem = Input::get('offsystem');

        $devices = array();
        $devices = explode("|", $onsystem);
        for($i=0; $i<count($devices) - 1; $i++){
            $combo = explode("-", $devices[$i]);
            $system = $combo[0];
            $this_device = Device::find($combo[1]);
            $this_device->system_id = $system;
            $this_device->save();
        }


        $devices = explode("|", $offsystem);
        for($i=0; $i<count($devices) - 1; $i++){
            $combo = explode("-", $devices[$i]);
            $system = $combo[0];
            $this_device = Device::find($combo[1]);
            $this_device->system_id = "0";
            $this_device->save();

        }
        $global = 0;
        $message = "Successfully updated System-".System::find($system)->system_name;
        return redirect()->back()
            ->with('global', $global)
            ->with('message', $message);

    }
    /**
     *
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\System  $system
     * @return \Illuminate\Http\Response
     */
    public function show(System $system)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\System  $system
     * @return \Illuminate\Http\Response
     */
    public function edit(System $system)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\System  $system
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, System $system)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\System  $system
     * @return \Illuminate\Http\Response
     */
    public function destroy(System $system)
    {
        //
    }


}
