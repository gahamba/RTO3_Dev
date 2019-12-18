@extends('layouts.authlayout')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reports</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    @if(auth::user()->user_type == 0)
    <div class="container-fluid">

        <p class="float-right">
            <a class="btn contrast_component2" data-toggle="collapse" href="#createSystemPanel" role="button"
               aria-expanded="false" aria-controls="createDevicePanel">
                <i class="fas fa-cogs"></i>&nbsp;Configuration
            </a>
        </p>

        <div class="clearfix">&nbsp;&nbsp;</div>

        @if(Session::has('global'))

            <div class="alert alert-{{ session('global') == 0 ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


        @endif
        <div class="collapse" id="createSystemPanel">
            <div class="card card-body">

                <div class="container-fluid"></div>

                <h5>Configure Report Times</h5>
                <br />
                @if(isset($config))
                    <h4 class="text-center">Report will print at

                        @foreach($config->times as $time)

                            <span class="badge badge-info">{{ $time }}:00</span>

                        @endforeach
                        Add fields below to select new times

                    </h4>
                    <h6 class="text-danger text-center">
                        *(Any new fields added will over-write existing ones)
                    </h6>

                @endif

                <form method="post" action="{{ route('config-post') }}">
                    @csrf


                    <button id="add" class="btn btn-sm btn-secondary">Add new field</button>
                    <br />
                    <!-----------------------
                     multiple textboxes shall be added here as
                     <input type="text" class="someclass"> ---x> textbox 1
                     <input type="text" class="someclass"> ---x> textbox 2
                     ------------------------>


                    <br />
                    <p class="float-right"><button type="submit" class="btn btn-primary">Save this config</button></p>





                </form>

            </div>


        </div>

    </div>

    @endif
    <div class="clearfix">&nbsp;&nbsp;</div>

    <div id="report_content">



    </div>

    <script src="{{ asset('js/reports.js') }}" defer></script>
    <style>
        .react-datepicker-wrapper{
            display: block;
        }
    </style>
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script>
        $(function() {
            $('#add').on('click', function( e ) {

                e.preventDefault();

                $('<div/>').addClass( 'row' ).append(
                    $('<div/>').addClass( 'col-10' ).append(
                        $('<div/>').addClass( 'form-group' )
                            .html( $('<select name="times[]"/>').addClass( 'form-control' )
                                .append($('<option>').val('0').text('Midnight'))
                                .append($('<option>').val('1').text('1 AM'))
                                .append($('<option>').val('2').text('2 AM'))
                                .append($('<option>').val('3').text('3 AM'))
                                .append($('<option>').val('4').text('4 AM'))
                                .append($('<option>').val('5').text('5 AM'))
                                .append($('<option>').val('6').text('6 AM'))
                                .append($('<option>').val('7').text('7 AM'))
                                .append($('<option>').val('8').text('8 AM'))
                                .append($('<option>').val('9').text('9 AM'))
                                .append($('<option>').val('10').text('10 AM'))
                                .append($('<option>').val('11').text('11 AM'))
                                .append($('<option>').val('12').text('12 NOON'))
                                .append($('<option>').val('13').text('1 PM'))
                                .append($('<option>').val('14').text('2 PM'))
                                .append($('<option>').val('15').text('3 PM'))
                                .append($('<option>').val('16').text('4 PM'))
                                .append($('<option>').val('17').text('5 PM'))
                                .append($('<option>').val('18').text('6 PM'))
                                .append($('<option>').val('19').text('7 PM'))
                                .append($('<option>').val('20').text('8 PM'))
                                .append($('<option>').val('21').text('9 PM'))
                                .append($('<option>').val('22').text('10 PM'))
                                .append($('<option>').val('23').text('11 PM'))

                            )
                    )

                ).append( $('<div/>').addClass( 'col-2' ).html(
                    $('<button/>').addClass( 'remove btn btn-sm btn-danger' ).text( 'Remove' )
                    )
                )
                    .insertBefore( this );

                $(document).on('click', 'button.remove', function( e ) {
                    e.preventDefault();
                    $(this).closest( 'div.row' ).remove();
                });

            });

        });
    </script>


@endsection
