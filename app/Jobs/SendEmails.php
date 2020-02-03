<?php

namespace App\Jobs;

use App\Mail\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

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
    public function __construct($email, $device)
    {
        $this->email = $email;
        $this->device = $device;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{

            Mail::to($this->email)->send(new Alert($this->device));
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
