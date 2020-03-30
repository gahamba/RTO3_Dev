<table>

    <thead>
    <tr align="center">

        <td align="center" colspan="{{ count($configuration) * max($intf) * count($dates) }}" style="text-align: left; height: 30px; font-size: 12px;">
            <strong>HACCP REPORT from {{ $dates[0]  }}
                to
                {{ $dates[count($dates) - 1] }}
            </strong>
        </td>
    </tr>
    <tr align="center">
        <td>&nbsp;</td>

        @foreach($dates as $date)
            <td align="center" colspan="{{ count($configuration) * max($intf) }}"><strong>{{ $date }}</strong></td>
        @endforeach

    </tr>
    <tr align="center">
        <td align="center">&nbsp;</td>
        @for($i=0; $i<count($dates); $i++)
            @foreach($configuration as $config)
                <td align="center" colspan="{{ max($intf) }}"><strong>{{ $config }}:00</strong></td>
            @endforeach
        @endfor
    </tr>
    </thead>
    <tbody>
    <?php $i =0; ?>
    @foreach($dailies as $day)

        <tr align="center">
            <td align="center">
                {{ $day[0]['sensor_name'] }}&nbsp;({{ $day[0]['sensor_id'] }})
            </td>
            @foreach($day as $daily)
                @foreach($daily['dataSamples'] as $dataSample)
                    @foreach($daily['points'] as $point )
                        @if(isset($dataSample[$point]) && $dataSample[$point] != 0)
                            @if($dataSample[$point.'-minV'] == 0 && $dataSample[$point.'-maxV'] == 0)
                                <td colspan="{{ max($intf)/count($daily['points']) }}" style="background-color: #28a745; color: #FFFFFF; height: 50px;">
                                    {{ round($dataSample[$point], 2) }}
                                </td>
                            @elseif($dataSample[$point.'-minV'] == -1 || $dataSample[$point.'-maxV'] == -1)
                                <td colspan="{{ max($intf)/count($daily['points']) }}" style="background-color: #f6993f; color: #FFFFFF; height: 50px;">
                                    {{ round($dataSample[$point], 2) }}
                                </td>
                            @else
                                <td colspan="{{ max($intf)/count($daily['points']) }}" style="background-color: #FF0000; color: #FFFFFF; height: 50px;">
                                    {{ round($dataSample[$point], 2) }}
                                </td>
                            @endif
                        @else
                            <td colspan="{{ max($intf)/count($daily['points']) }}" style="background-color: #cccccc; color: #FFFFFF; height: 50px;">

                            </td>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </tr>
        <?php $i++; ?>
    @endforeach
    </tbody>
</table>
