<?php

namespace App\Http\Controllers;

use App\Device;
use App\UserDeviceMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutineController extends Controller
{
    //
    public function fetchDevices(){
        if(auth::user()->company_id == -1){
            if(auth::user()->user_type == 0 || auth::user()->user_type == -1){
                $devices = Device::where('user_id', '=', auth::user()->id)
                    ->orderBy('name', 'DESC')->get();
                $systemmaps = [];

            }
            else{

                $systemmaps = UserDeviceMap::where('user_id', '=', auth::user()->id)
                    ->where('system_id', '<>', 0)->pluck('system_id');
                $devicemaps = UserDeviceMap::where('user_id', '=', auth::user()->id)->pluck('device_id');

                if(count($systemmaps) > 0){
                    $devices1 = Device::whereIn('_id', $devicemaps)
                        ->whereNotIn('system_id', $systemmaps)
                        ->orderBy('unique_id', 'DESC')->get();
                    $devices2 = Device::whereIn('system_id', $systemmaps)
                        ->orderBy('unique_id', 'DESC')->get();
                    $devices = $devices1->merge($devices2);
                }
                else{
                    $devices = Device::whereIn('_id', $devicemaps)
                        ->orderBy('unique_id', 'DESC')->get();
                }
            }

        }
        else{
            if(auth::user()->user_type == 0 || auth::user()->type == "0" || auth::user()->user_type == -1){
                $devices = Device::where('company_id', '=', auth::user()->company_id)
                    ->orderBy('name', 'DESC')->get();
                $systemmaps = [];

            }
            else{
                $systemmaps = UserDeviceMap::where('user_id', '=', auth::user()->id)
                    ->where('system_id', '<>', 0)->pluck('system_id');
                $devicemaps = UserDeviceMap::where('user_id', '=', auth::user()->id)->pluck('device_id');

                if(count($systemmaps) > 0){
                    $devices1 = Device::whereIn('_id', $devicemaps)
                        ->whereNotIn('system_id', $systemmaps)
                        ->orderBy('unique_id', 'DESC')->get();
                    $devices2 = Device::whereIn('system_id', $systemmaps)
                        ->orderBy('unique_id', 'DESC')->get();
                    $devices = $devices1->merge($devices2);
                }
                else{
                    $devices = Device::whereIn('_id', $devicemaps)
                        ->orderBy('unique_id', 'DESC')->get();
                }


            }

        }

        return $devices;
    }
}
