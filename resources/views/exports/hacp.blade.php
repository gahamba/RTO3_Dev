<table>

    <thead>
    <tr>
        <td align="center" colspan="{{ count($configuration) + 1 }}" style="text-align: left; height: 30px; font-size: 12px;">
            <strong>HACCP REPORT for {{ $intf }} from {{ (new \App\Http\Controllers\DateController())->convertMongoToY_M_D($dailies[0]['dataSamples'][0]['recordDate'])  }}
                to
                {{ (new \App\Http\Controllers\DateController())->convertMongoToY_M_D($dailies[count($dailies) - 1]['dataSamples'][0]['recordDate']) }}
                for Sensor ID: {{ $dailies[0]['sensorId'] }}</strong>
        </td>
    </tr>
    <tr>
        <td align="center">&nbsp;</td>
        @foreach($configuration as $config)
            <td align="center"><strong>{{ $config }}:00</strong></td>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($dailies as $daily)
        <tr>
            <td align="center">
                {{ (new \App\Http\Controllers\DateController())->convertMongoToY_M_D($daily['dataSamples'][0]['recordDate']) }}</td>
            @foreach($daily['dataSamples'] as $dataSample)
                @if(isset($dataSample[$intf]))
                    @if($dataSample[$intf.'-minV'] == 0 && $dataSample[$intf.'-maxV'] == 0)
                        <td style="background-color: #28a745; color: #FFFFFF; height: 50px;">
                            {{ round($dataSample[$intf], 2) }}
                        </td>
                    @elseif($dataSample[$intf.'-minV'] == -1 || $dataSample[$intf.'-maxV'] == -1)
                        <td style="background-color: #f6993f; color: #FFFFFF; height: 50px;">
                            {{ round($dataSample[$intf], 2) }}
                        </td>
                    @else
                        <td style="background-color: #FF0000; color: #FFFFFF; height: 50px;">
                            {{ round($dataSample[$intf], 2) }}
                        </td>
                    @endif
                @else
                    <td style="background-color: #f6993f; color: #FFFFFF; height: 50px;">
                        NaN
                    </td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
