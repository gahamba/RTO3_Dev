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

    <div class="container-fluid">
        <div class="card card-body">

            <!--List of all companies starts -->
            <table class="table table-striped table-hover w-100" align="center">
                <thead>
                <tr>
                    <td scope="col"><i class="fas fa-building"></i>&nbsp;Company Name</td>
                    <td scope="col">Enter</td>
                </tr>
                </thead>

                <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{ $company->company_name }}</td>
                        <td><a href="{{ route('companyselect', $company->id) }}"><i class="fas fa-door-open"></i></a></td>

                    </tr>



                @endforeach


                </tbody>

            </table>

            <!-- List of all systems end here -->

        </div>
    </div>

    {{--<div class="container-fluid" id="company_content">



    </div>



    <script src="{{ asset('js/company.js') }}" defer></script>--}}

@endsection
