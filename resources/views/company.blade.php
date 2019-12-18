@extends('layouts.authlayout')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Companies</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    <div class="container-fluid" id="company_content">



    </div>



    <script src="{{ asset('js/company.js') }}" defer></script>

@endsection
