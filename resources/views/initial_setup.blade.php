@extends('layouts.getstartedlayout')

@section('content')


    <div class="container">
            <div class="row m-5">
                <div class="col-md">
                    <h5 class="text-center">
                        Let's get you started in a few easy steps
                    </h5>
                </div>
            </div>
            <div class="row m-5">
                <div class="col-md-3 text-center card">
                    <a href="{{ route('initial_device') }}">
                        <br />
                        <br />
                        <span class="badge badge-pill badge-success">1</span>
                        <br /><br />
                        Add <span class="badge badge-info">Sensor/Device</span> to start Realtime monitoring
                        <br />
                        <div class="btn btn-sm btn-primary">click to start</div>
                        <br /><br /><br />
                    </a>
                </div>
                <div class="col-md-3 text-center border-right border-bottom">
                    <a href="{{ route('initial_device') }}">
                        <br />
                        <br />
                        <span class="badge badge-pill badge-success">2</span>
                        <br /><br />
                        Add <span class="badge badge-info">System</span>. Devices can be better managed under Systems
                        <br /><br /><br />
                    </a>
                </div>
                <div class="col-md-3 text-center border-right border-bottom">
                    <a href="{{ route('initial_device') }}">
                        <br />
                        <br />
                        <span class="badge badge-pill badge-success">3</span>
                        <br /><br />
                        Add <span class="badge badge-info">Users</span>. Add other users in your organization as Super Administrators or Regular Administrators. You can then delegate devices or systems to them.
                        <br /><br /><br />
                    </a>
                </div>
                <div class="col-md-3 text-center">
                    <a href="{{ route('initial_device') }}">
                        <br />
                        <br />
                        <span class="badge badge-pill badge-success">4</span>
                        <br /><br />
                        After set-up, you can start using RealTime Online
                        <br />
                        <i class="fas fa-2x fa-check-circle text-success"></i>

                        <br /><br /><br />
                    </a>
                </div>
            </div>

    </div>

    <script src="{{ asset('js/home.js') }}" defer></script>

@endsection
