@extends('layouts.authlayout')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Messages</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    <div class="card card-body">
            <div class="container-fluid">
                <div class="row">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>SensorId</th>
                            <th>Subject</th>
                            <th>DateTime</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($messages as $message)

                            <tr @if($message->read == 0)bgcolor="#cccccc"@endif>

                                <td>{{ $message->sensorId }}</td>
                                <td><span class="badge @if($message->status == "Critical")badge-danger @else badge-warning @endif">{{ $message->status }}</span>&nbsp;{{ $message->subject }}</td>
                                <td>{{ $message->time }}</td>

                            </tr>


                        @endforeach

                        </tbody>
                    </table>
                </div>


        </div>



    </div>




@endsection
