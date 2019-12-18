<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use App\UserDeviceMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Landing page for messages
     *
     */
    public function landing(){
        $messages = Message::where('user_id', '=', Auth::user()->_id)
                            ->orderBy('created_at', 'desc')->get();
        return view('messages')
                ->with('messages', $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::where('user_id', '=', Auth::user()->_id)->get();
        return response()->json(count($messages));
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
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }

    /*
     * Add new message for warning and bad
     *
     */
    public function newMessage($device, $val, $status){
        $users = User::where('company_id', '=', $device->company_id)
                        ->where('user_type', '=', "0")->pluck('_id');
        $tusers = UserDeviceMap::where('device_id', '=', $device->id)->pluck('user_id');
        $message = "The following device is in bad condition. <br /> Device name: ".$device->name."<br />Sensor Id: ".$device->unique_id."<br />Current Reading: ".$val."<br />Thresholds: Minumum -".$device->min_threshold." Maximum -".$device->max_threshold;

        $mes = Message::where('sensorId', '=', $device->unique_id)
                            ->orderBy('created_at', 'DESC')->first();

        if($mes){
            $now = strtotime(date('Y-m-d H:i:s'));
            $last_update = strtotime($mes->time);

            if(abs($now - $last_update) / 60 > 5){
                /*$a = 10;
                if($a%3 == 0){*/
                foreach($users as $user){

                    Message::create(array(
                        'sensorId' =>   $device->unique_id,
                        'user_id'  =>   $user,
                        'subject'  =>   "Device - ".$device->name." in ".$status." condition",
                        'message'  =>   $message,
                        'sent'     =>   0,
                        'read'     =>   0,
                        'status'   =>   $status,
                        'time'     =>   date('Y-m-d H:i:s'),
                    ));
                    /*$this_user = User::find($user);
                    Mail::send('emails.alert', ['this_user' => $this_user], function ($m) use ($this_user, $status) {
                        $m->from('hello@app.com', 'Your Application');

                        $m->to($this_user->email, $this_user->name)->subject($status);
                    });*/
                }
                foreach($tusers as $user){

                    Message::create(array(
                        'sensorId' =>   $device->unique_id,
                        'user_id'  =>   $user,
                        'subject'  =>   "Device - ".$device->name." in ".$status." condition",
                        'message'  =>   $message,
                        'sent'     =>   0,
                        'read'     =>   0,
                        'status'   =>   $status,
                        'time'     =>   date('Y-m-d H:i:s'),
                    ));
                    /*$this_user = User::find($user);
                    Mail::send('emails.alert', ['this_user' => $this_user], function ($m) use ($this_user, $status) {
                        $m->from('hello@app.com', 'Your Application');

                        $m->to($this_user->email, $this_user->name)->subject($status);
                    });*/
                }
            }
        }
        else{
            foreach($users as $user){

                Message::create(array(
                    'sensorId' =>   $device->unique_id,
                    'user_id'  =>   $user,
                    'subject'  =>   "Device - ".$device->name." in ".$status." condition",
                    'message'  =>   $message,
                    'sent'     =>   0,
                    'read'     =>   0,
                    'status'   =>   $status,
                    'time'     =>   date('Y-m-d H:i:s'),
                ));
                /*$this_user = User::find($user);
                Mail::send('emails.alert', ['this_user' => $this_user], function ($m) use ($this_user, $status) {
                    $m->from('hello@app.com', 'Your Application');

                    $m->to($this_user->email, $this_user->name)->subject($status);
                });*/
            }
            foreach($tusers as $user){

                Message::create(array(
                    'sensorId' =>   $device->unique_id,
                    'user_id'  =>   $user,
                    'subject'  =>   "Device - ".$device->name." in ".$status." condition",
                    'message'  =>   $message,
                    'sent'     =>   0,
                    'read'     =>   0,
                    'status'   =>   $status,
                    'time'     =>   date('Y-m-d H:i:s'),
                ));
                /*$this_user = User::find($user);
                Mail::send('emails.alert', ['this_user' => $this_user], function ($m) use ($this_user, $status) {
                    $m->from('hello@invisible-systems.com', 'Your Alert');

                    $m->to($this_user->email, $this_user->name)->subject($status);
                });*/
            }
        }



    }
}
