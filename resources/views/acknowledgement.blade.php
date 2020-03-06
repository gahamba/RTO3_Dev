@extends('layouts.authlayout2')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Acknowledgement</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    <div class="container-fluid">
        <div class="card card-body">
            <h4 align="center">Device: {{ $device->name }} ({{ $device->unique_id }})</h4>

            <div class="container-fluid">

                <div class="row">

                    <div class="container-fluid">

                        <h4 align="center">Corrective Action</h4>
                        @if(Session::has('global'))

                            <div class="alert alert-{{ session('global') == 0 ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                                {{ session('global') == 0 ? 'Successfully added comment' : 'Unable to add corrective action at this time' }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                        @endif
                        <form method="post" action="{{ route('acknowledge-post') }}">

                            @csrf
                            <div class="form-group text-center">
                                <label><i class="fas fa-clock"></i>&nbsp;
                                    Last Update</label>

                                <div class="row">
                                    <div class="col-sm">
                                        {{ $last_update }}
                                    </div>



                                </div>

                            </div>

                            <div class="{{ $show_textarea === true ? '' : 'd-none' }}">
                                <input type="hidden" value="{{ $device_array[0] }}" name="device_id" />
                                <input type="hidden" value="{{ $device_array[1] }}" name="reading" />
                                <input type="hidden" value="{{ $device_array[2] }}" name="min_threshold" />
                                <input type="hidden" value="{{ $device_array[3] }}" name="max_threshold" />

                                <div class="form-group">
                                    <label htmlFor="deviceDescription"><i class="fas fa-info"></i>&nbsp;Device
                                        Corrective Action</label>
                                    <textarea class="form-control"
                                              aria-describedby="deviceDescriptionHelp"
                                              placeholder="Enter corrective action"
                                              name="correction"  >


                                    </textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Add</button>

                            </div>



                        </form>

                    </div>


                </div>



            </div>

            <br />
            <br />


            <div class="container-fluid">

                <div class="row">

                    <div class="col-sm overflow-auto h-25">

                        <h6 align="center">Corrections</h6>
                        <table class="table table-sm table-striped table-hover w-100" align="center">
                            <thead>
                            <tr>
                                <td scope="col">Actioned By</td>
                                <td scope="col">Correction</td>
                                <td scope="col">Date Time</td>
                                <td scope="col"></td>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($corrections as $correction)

                                <tr>
                                    <td>
                                        {{ \App\User::find($correction->user_id)->name }}
                                    </td>
                                    <td>
                                        {{ $correction->correction }}
                                    </td>
                                    <td>
                                        {{ $correction->date }} {{ $correction->time }}
                                    </td>
                                    <td>

                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>


        </div>
    </div>

</div>

@endsection

