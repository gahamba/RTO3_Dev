@extends('layouts.getstartedlayout')

@section('content')
    <br />
    <div class="container-fluid">
        <div class="row">
            <div class="col">

                <div class="alert alert-info alert-dismissible text-center">
                    Add Device/Sensor by clicking the "Add Device" Button. You'll then be able to enter your Sensor ID and set up sensor.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h4 class="text-center"><span class="badge badge-pill badge-success">1</span></h4>
                @if(Session::has('global'))

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Sorry! You need to add Device/Sensor before proceeding.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                @endif

            </div>
        </div>
    </div>


    <div class="container-fluid" id="device_content">



    </div>


    <br />
    <p class="text-center"><a href="{{ route('initial_system') }}" class="btn btn-sm badge-pill badge-success">Next Step</a></p>
    <script src="{{ asset('js/device.js') }}" defer></script>


@endsection
