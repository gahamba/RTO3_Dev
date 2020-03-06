<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Alert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $device, $reading, $min_threshold, $max_threshold;

    public function __construct($device, $reading, $min_threshold, $max_threshold)
    {
        //
        $this->device = $device;
        $this->reading = $reading;
        $this->min_threshold = $min_threshold;
        $this->max_threshold = $max_threshold;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('alarms@invisible-systems.com')
                    ->markdown('emails.alarm.alert');
    }
}
