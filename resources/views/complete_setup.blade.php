@extends('layouts.getstartedlayout')

@section('content')


    <div class="container">
            <div class="row m-5">
                <div class="col-md">
                    <h5 class="text-center">
                        See? Setting up your dashboard has never been easier <i class="fas fa-smile-wink text-success"></i>
                    </h5>
                </div>
            </div>
            <div class="row m-5 text-center">

                <div class="col-md text-center card">
                    <a href="{{ route('home') }}">
                        <br />
                        <br />
                        <h4><span class="badge badge-pill badge-success">4</span></h4>
                        <br /><br />
                        <h5 class="text-center">Congratulations! You are now fully set up</h5>

                        <br />
                        <i class="fas fa-2x fa-check-circle text-success"></i>
                        <p class="text-center">You can now proceed to your new Dashboard</p>
                        <br />
                        <div class="btn btn-sm btn-success">Proceed</div>
                        <br /><br /><br />
                    </a>
                </div>
            </div>

    </div>

    <script src="{{ asset('js/home.js') }}" defer></script>

@endsection
