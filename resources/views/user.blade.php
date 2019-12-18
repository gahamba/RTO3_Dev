@extends('layouts.authlayout')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    <div class="container-fluid" id="user_content">

            <p class="float-right">
                <a class="btn contrast_component2" data-toggle="collapse" href="#createDevicePanel" role="button"
                   aria-expanded="false" aria-controls="createDevicePanel">
                    <i class="fas fa-plus-square"></i>&nbsp;Add User
                </a>
            </p>

            <div class="clearfix">&nbsp;</div>
            <div class="collapse" id="createDevicePanel">
                <div class="card card-body">

                    <h4>Create New User</h4>
                    <form onSubmit={this.handleSubmit}>


                        <div>

                            <div class="form-group">
                                <label htmlFor="adminType"><i class="fas fa-cog"></i>&nbsp;User Type (select one)</label>
                                <select multiple class="form-control" id="adminType">
                                    <option value="0">Super (Has all permissions)</option>
                                    <option value="1">Regular (Limited permissions)</option>
                                </select>


                            </div>

                            <div class="form-group">
                                <label htmlFor="userName"><i class="fas fa-user"></i>&nbsp;User
                                    Name</label>
                                <input type="text" class="form-control" placeholder="Ashley Wright" id="userName" />

                            </div>

                            <div class="form-group">
                                <label htmlFor="email"><i class="fas fa-envelope"></i>&nbsp;Email</label>
                                <input type="email" class="form-control" placeholder="ashley@yahoo.com" id="email"/>

                            </div>


                            <button type="submit" class="btn btn-primary">Add</button>

                        </div>



                    </form>

                </div>
            </div>

            <div class="clearfix">&nbsp;</div>



        <div class="card card-body">

                <h4>Users</h4>

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-sm-4 d-flex">
                            <div class="container card card-body light_panel space_inner">

                                <div class="row">

                                    <div class="col-sm-4 text-center right_border">

                                        <img class="rounded-circle user_profile2" src="{{ URL::asset('images/user.png') }}" />
                                        {{--                                    <p class="font-weight-bold">Godson Ahabma</p>--}}
                                        <p><span class="badge badge-info contrast_component2">Godson Ahamba</span></p>




                                    </div>

                                    <div class="col-sm-8 text-center">

                                        <!--<i class="fas fa-edit text-primary"></i>&nbsp;&nbsp;<i class="fas fa-trash text-danger"></i>-->
                                        <h4 align="center">Details <a href="#"><i class="fas fa-cog text_contrast2"></i></a></h4>
                                        <p class=""><i class="fas fa-envelope"></i>&nbsp; ageplanet@yahoo.com</p>
                                        <p class=""><i class="fas fa-phone"></i>&nbsp; 07438242382</p>
                                        <p>
                                            <a href="#" class="btn btn-sm btn-warning">Reset Account</a>&nbsp;
                                            <a href="#" class="btn btn-sm">Send In-Message</a>
                                        </p>

                                    </div>

                                </div>


                            </div>
                        </div>






                    </div>


                </div>

            </div>


    </div>






    <script src="{{ asset('js/user.js') }}" defer></script>


@endsection
