@extends('layouts.getstartedlayout')

@section('content')

    <br />
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="alert alert-info alert-dismissible text-center">
                    Add other Users by clicking the "Add User" Button.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h4 class="text-center"><span class="badge badge-pill badge-success">3</span></h4>

            </div>
        </div>
    </div>

    <div class="container-fluid" id="user_content">




    </div>

    <br />
    <p class="text-center"><a href="{{ route('complete_setup') }}" class="btn btn-sm badge-pill badge-success">Next Step</a></p>




    <script src="{{ asset('js/user.js') }}" defer></script>


@endsection
