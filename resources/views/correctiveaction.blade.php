@extends('layouts.authlayout')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Action</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    <div class="container-fluid">


        <!--<div>-->
            <p class="float-right">
                <a class="btn contrast_component2" data-toggle="collapse" href="#createSystemPanel" role="button"
                   aria-expanded="false" aria-controls="createDevicePanel">
                    <i class="fas fa-plus-square"></i>&nbsp;Add Corrective Action
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



                    <h4>Add corrective action</h4>
                    <form method="post" action="{{ route('correctiveaction-post') }}">
                        @csrf


                            <div class="form-group">
                                <label htmlFor="systemDescription"><i class="fas fa-info"></i>&nbsp;Corrective Action </label>
                                <textarea class="form-control" id="systemDescription" name="corrective_action"
                                          aria-describedby="systemDescriptionHelp"
                                          placeholder="Enter system description" required>


                                </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add</button>





                    </form>

            </div>


        </div>


        <div class="clearfix">&nbsp;</div>

        <div class="card card-body">
            <h4>Corrective Actions</h4>


            <!--List of all Corrective Actions starts -->
            <table class="table table-striped table-hover w-100" align="center">
                <thead>
                <tr>
                    <td scope="col"><i class="fas fa-user"></i>Created By</td>
                    <td scope="col"><i class="fas fa-layer-group"></i>Action</td>
                    <td scope="col"></td>
                </tr>
                </thead>

                <tbody>
                @foreach($actions as $action)
                    <tr>
                        <td>{{ App\User::find($action->created_by)->name }}</td>
                        <td>{{ $action->action }}</td>
                        <td>
                            <div class="row">

                                <div class="col-sm"><a href="#" data-toggle="modal" data-target="#editModal{{ $action->id }}"><i class="far fa-edit text-primary"></i>&nbsp;Edit </a></div>
                                <div class="col-sm"><a href="#" data-toggle="modal" data-target="#deleteModal{{ $action->id }}"><i class="fas fa-times text-danger"></i>&nbsp;Delete </a></div>
                            </div>


                            <!-- Edit modal starts here -->

                            <div class="modal fade" id="editModal{{ $action->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-full" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="btn btn-danger">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">


                                            <form method="post" action="{{ route('update_correctiveaction-post') }}">
                                                @csrf

                                                <input type="hidden" name="action_id" value="{{ $action->id }}" />

                                                <div class="form-group">
                                                    <label htmlFor="systemDescription"><i class="fas fa-info"></i>&nbsp;Action</label>
                                                    <textarea class="form-control" id="systemDescription" name="corrective_action"
                                                              aria-describedby="systemDescriptionHelp"
                                                              placeholder="Enter system description" required>

                                                        {{ $action->action }}

                                                    </textarea>
                                                </div>



                                                <button type="submit" class="btn btn-primary">Edit</button>





                                            </form>




                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Edit modal ends here -->

                            <!--Delete Modal starts-->

                            <div class="modal fade" id="deleteModal{{ $action->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">

                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="btn btn-danger">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h5 class="badge badge-info">Delete {{ $action->action }}?</h5>
                                            <form method="post" action="{{ route('delete_correctiveaction-post') }}">
                                                @csrf
                                                <input type="hidden" name="system_id" value="{{ $action->id }}" />
                                                <button class="btn btn-lg btn-danger">Delete now</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--Delete Modal ends-->



                        </td>
                    </tr>



                @endforeach


                </tbody>

            </table>

            <!-- List of all corrective actions end here -->




        </div>


    <!--</div>-->







    </div>




@endsection
