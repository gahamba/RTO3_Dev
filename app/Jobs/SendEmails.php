<?php

namespace App\Jobs;

use App\Mail\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $email;
    protected $device;
    protected $min_threshold;
    protected $max_threshold;
    protected $reading;

    public function __construct($email, $device, $reading, $min_threshold, $max_threshold)
    {
        $this->email = $email;
        $this->device = $device;
        $this->reading = $reading;
        $this->min_threshold = $min_threshold;
        $this->max_threshold = $max_threshold;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            if($this->device->delay_active == "1"){
                $now = strtotime(date('Y-m-d H:i:s'));

                if(Redis::get($this->device)){
                    if(($now - strtotime(Redis::get($this->device)))/60 >= $this->device->delay_minutes){
                        Mail::to($this->email)->send(new Alert($this->device, $this->reading, $this->min_threshold, $this->max_threshold));
                    }
                }
                else{
                    Redis::set($this->device->unique_id, date('Y-m-d H:i:s'));
                }
                /*$when =  now()->addMinutes($this->device->delay_minutes);
                Mail::to($this->email)->later($when, new Alert($this->device, $this->reading, $this->min_threshold, $this->max_threshold));*/
            }
            else{
                Mail::to($this->email)->send(new Alert($this->device, $this->reading, $this->min_threshold, $this->max_threshold));
            }

        }
        catch (Exception $ex){
            $this->failed($ex);
        }

    }

    public function failed($ex)
    {
        $ex->getMessage();
    }

    /*public function fire($job, $data){
        Mail::to($data)->send(new Alert());
        $job->delete();
    }*/
}
