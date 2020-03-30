<?php

namespace App\Exports;

use App\Configuration;
use App\MongoSensorData;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class HacpExport implements FromView
{
    protected $dailies, $count_interfaces, $configuration, $dates;
    public function __construct($dailies, $count_interfaces, $configuration, $dates)
    {
        $this->dailies = $dailies;
        $this->count_interfaces = $count_interfaces;
        $this->configuration = $configuration;
        $this->dates = $dates;
    }
    public function view(): View
    {

        return view('exports.hacp', [
            'dailies' => $this->dailies,
            'configuration' =>  $this->configuration,
            'intf'          =>  $this->count_interfaces,
            'dates'         =>  $this->dates
        ]);
    }
}
