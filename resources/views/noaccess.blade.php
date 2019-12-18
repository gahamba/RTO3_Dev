@extends('layouts.authlayout')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">No access</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">
                <div class="alert alert-warning w-100">Sorry, you do not have permission to access this page</div>
            </div>

        </div>

    </div>

@endsection
