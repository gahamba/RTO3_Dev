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
    protected $dailies, $interface;
    public function __construct($dailies, $interface)
    {
        $this->dailies = $dailies;
        $this->interface = $interface;
    }
    public function view(): View
    {
        $configuration = Configuration::where('companyId', '=', auth::user()->company_id)->first()->times;
        if(!$configuration){
            $configuration = ['0', '12', '16', '22'];
        }
        return view('exports.hacp', [
            'dailies' => $this->dailies,
            'configuration' =>  $configuration,
            'intf'          =>  $this->interface,
        ]);
    }
}
