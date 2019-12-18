@extends('layouts.authlayout')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Systems</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    <div class="container-fluid">


        <!--<div>-->
            <p class="float-right">
                <a class="btn contrast_component2" data-toggle="collapse" href="#createSystemPanel" role="button"
                   aria-expanded="false" aria-controls="createDevicePanel">
                    <i class="fas fa-plus-square"></i>&nbsp;Add System
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



                    <h4>Create System</h4>
                    <form method="post" action="{{ route('system-post') }}">
                        @csrf
                            <div class="form-group">
                                <label htmlFor="deviceUniqueId"><i class="fab fa-acquisitions-incorporated"></i>&nbsp;
                                    System Name</label>


                                <input type="text" class="form-control" id="system_name" name="system_name"
                                       aria-describedby="systemNameHelp" placeholder="Specify system name" required />


                            </div>

                            <div class="form-group">
                                <label htmlFor="systemDescription"><i class="fas fa-info"></i>&nbsp;System
                                    Description</label>
                                <textarea class="form-control" id="systemDescription" name="system_description"
                                          aria-describedby="systemDescriptionHelp"
                                          placeholder="Enter system description" required>


                                </textarea>
                            </div>

                            <div class="form-group">
                                <label htmlFor="systemLocation"><i class="fas fa-search-location"></i>&nbsp;System
                                    Location</label>
                                <textarea class="form-control" id="systemLocation" name="system_location"
                                      aria-describedby="systemLocationHelp"
                                      placeholder="Enter system description" required>

                                </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add</button>





                    </form>

            </div>


        </div>


        <div class="clearfix">&nbsp;</div>

        <div class="card card-body">
            <h4>Systems</h4>


            <!--List of all Systems starts -->
            <table class="table table-striped table-hover w-100" align="center">
                <thead>
                <tr>
                    <td scope="col"><i class="fas fa-layer-group"></i>System</td>
                    <td scope="col"><i class="fas fa-user"></i>Created By</td>
                    <td scope="col"></td>
                </tr>
                </thead>

                <tbody>
                @foreach($systems as $system)
                    <tr>
                        <td>{{ strip_tags($system->system_name) }}</td>
                        <td>{{ App\User::find($system->created_by)->name }}</td>
                        <td>
                            <div class="row">
                                <div class="col-sm"><a href="#" data-toggle="modal" data-target="#detailsModal{{ $system->id }}"><i class="far fa-eye text-info"></i>&nbsp;Details </a></div>
                                <div class="col-sm"><a href="#" data-toggle="modal" data-target="#editModal{{ $system->id }}"><i class="far fa-edit text-primary"></i>&nbsp;Edit </a></div>
                                <div class="col-sm"><a href="#" data-toggle="modal" data-target="#deleteModal{{ $system->id }}"><i class="fas fa-times text-danger"></i>&nbsp;Delete </a></div>
                            </div>

                            <!-- Details modal starts here -->
                            <div class="modal fade" id="detailsModal{{ $system->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailsModalLabel"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">

                                            <div class="">
                                                <h5><i class="fab fa-acquisitions-incorporated"></i>&nbsp;System Name</h5>
                                                <p> {{ $system->system_name }} </p>

                                                <h5><i class="fas fa-info"></i>&nbsp;System Description</h5>
                                                <p> {{ strip_tags($system->system_description) }} </p>

                                                <h5><i class="fas fa-search-location"></i>&nbsp;System Location</h5>
                                                <p> {{ strip_tags($system->system_location) }} </p>

                                                <br />
                                                <h4><span class="badge badge-info"><i class="fas fa-microchip"></i>&nbsp;&nbsp;Devices</span></h4>
                                                <br />

                                                <div class="container-fluid">

                                                    <h5>Devices on this System</h5>
                                                    <p>(Drag devices into the space below to tie them to this system)</p>
                                                    <hr />
                                                    <div class="row" style="min-height: 50px;">

                                                        <?php
                                                            $devs =  \App\Device::where('system_id', '=', $system->id)->get();
                                                            $i = 0;
                                                            $j = 0;
                                                        ?>
                                                        @foreach($devs as $device)
                                                            <div class="col-sm-3 float-left" name="add_device" id="landing1{{ $system->id }}{{ $device->id }}" ondrop="drop(event)" ondragover="allowDrop(event)">

                                                                <div class="card contrast_component2" id="drag{{ $system->id }}{{ $device->id }}" draggable="true" ondragstart="drag(event)">
                                                                    <p class="d-none">{{ $system->id }}-{{ $device->id }}</p>
                                                                    <div class="card-body">
                                                                        <i class="fas fa-microchip"></i>&nbsp;{{ $device->name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        @while($i < count($devices))
                                                            <div class="col-sm-3 float-left" name="add_device" id="freelanding1{{ $system->id }}{{ $i }}" ondrop="drop(event)" ondragover="allowDrop(event)">


                                                            </div>

                                                            <?php $i++; ?>
                                                        @endwhile


                                                    </div>
                                                    <hr />

                                                    <br />

                                                    <h5>Other Devices</h5>
                                                    <p>(Drag devices into the space below to untie them from this system)</p>
                                                    <hr />
                                                    <div class="row" style="min-height: 50px;">

                                                        @foreach($devices as $device)
                                                            <div class="col-sm-3 float-left" name="remove_device" id="landing{{ $system->id }}{{ $device->id }}" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                                <div class="card contrast_component2" id="drag{{ $system->id }}{{ $device->id }}" draggable="true" ondragstart="drag(event)">
                                                                    <p class="d-none">{{ $system->id }}-{{ $device->id }}</p>
                                                                    <div class="card-body">
                                                                        <i class="fas fa-microchip"></i>&nbsp;{{ $device->name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @while($j < count($devs))
                                                            <div class="col-sm-3 float-left" name="remove_device" id="freelanding{{ $system->id }}{{ $j }}" ondrop="drop(event)" ondragover="allowDrop(event)">


                                                            </div>

                                                            <?php $j++; ?>
                                                        @endwhile

                                                        @foreach($assigned_devices as $device)
                                                            @if($device->system_id !== $system->id)
                                                            <div class="col-sm-3 float-left" name="remove_device">
                                                                <div class="card bg-transparent">

                                                                    <div class="card-body">
                                                                        <i class="fas fa-microchip"></i>&nbsp;{{ $device->name }}<br />
                                                                        @if($device->system_id != "0")
                                                                        [ {{ \App\System::find($device->system_id)->system_name }} ]

                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        @endforeach



                                                    </div>
                                                    <hr />

                                                    <br />
                                                    <p class="updateModalA"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#updateModal">Save changes on this system</a></p>

                                                </div>
                                            </div>




                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Details modal ends here -->


                            <!-- Edit modal starts here -->

                            <div class="modal fade" id="editModal{{ $system->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-full" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">


                                            <form method="post" action="{{ route('update_system-post') }}">
                                                @csrf

                                                <input type="hidden" name="system_id" value="{{ $system->id }}" />
                                                <div class="form-group">
                                                    <label htmlFor="deviceUniqueId"><i class="fab fa-acquisitions-incorporated"></i>&nbsp;
                                                        System Name</label>


                                                    <input type="text" class="form-control" id="system_name" name="system_name"
                                                           aria-describedby="systemNameHelp" placeholder="Specify system name"
                                                            value="{{ $system->system_name }}" required />


                                                </div>

                                                <div class="form-group">
                                                    <label htmlFor="systemDescription"><i class="fas fa-info"></i>&nbsp;System
                                                        Description</label>
                                                    <textarea class="form-control" id="systemDescription" name="system_description"
                                                              aria-describedby="systemDescriptionHelp"
                                                              placeholder="Enter system description" required>

                                                        {{ $system->system_description }}

                                                    </textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label htmlFor="systemLocation"><i class="fas fa-search-location"></i>&nbsp;System
                                                        Location</label>
                                                    <textarea class="form-control" id="systemLocation" name="system_location"
                                                              aria-describedby="systemLocationHelp"
                                                              placeholder="Enter system description" required>

                                                        {{ $system->system_location }}

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

                            <div class="modal fade" id="deleteModal{{ $system->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">

                                    <div class="modal-content">

                                        <div class="modal-body text-center">
                                            <h5 class="badge badge-info">Delete {{ $system->system_name }}?</h5>
                                            <form method="post" action="{{ route('delete_system-post') }}">
                                                @csrf
                                                <input type="hidden" name="system_id" value="{{ $system->id }}" />
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

            <!-- List of all systems end here -->


            <!--Modal confirm button starts-->

            <div class="modal fade" id="updateModal" tabindex="-3" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-body text-center">
                            <h5 class="badge badge-info">Changes cannot be undone</h5>
                            <form method="post" action="{{ route('system_devices-post') }}">
                                @csrf
                                <input name="onsystem" type="hidden" id="onsystem" />
                                <input name="offsystem" type="hidden" id="offsystem" />
                                <button id="update" class="btn btn-lg btn-danger">Save Change now</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!--Modal confirm button ends-->


        </div>


    <!--</div>-->







    </div>


    <script>
        document.getElementById("update").style.display = "none";
        var appBanners = document.getElementsByClassName('updateModalA'), i;

        for (var i = 0; i < appBanners.length; i ++) {
            appBanners[i].style.display = 'none';
        }
        document.getElementsByClassName("updateModalA")[0].style.display = "none";
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            /*var txt = document.getElementById("onsystem").value;
            if(txt.length === 0){*/
                ev.dataTransfer.setData("text", ev.target.id);
            /*}
            else {
                alert("please save changes first");
            }*/
        }

        function drop(ev) {
            ev.preventDefault();


                var data = ev.dataTransfer.getData("text");
                if(document.getElementById(ev.target.getAttribute("id")).innerHTML == null){
                    alert(document.getElementById(ev.target.getAttribute("id")).innerHTML);
                }
                else{
                    document.getElementById("update").style.display = "inline";
                    //document.getElementsByClassName("updateModalA").style.display = "inline";
                    for (var i = 0; i < appBanners.length; i ++) {
                        appBanners[i].style.display = 'inline';
                    }
                    ev.target.appendChild(document.getElementById(data));
                    //alert(document.getElementById(data).innerText || document.getElementById(data).textContent);
                    //alert(document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|"+ data);

                    if(document.getElementById("onsystem").value.includes(document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|")
                        || document.getElementById("onsystem").value.indexOf(document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|") !== -1){
                        document.getElementById("onsystem").value = document.getElementById("onsystem").value.replace(document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|", '');
                    }
                    if(document.getElementById("offsystem").value.includes(document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|")
                        || document.getElementById("offsystem").value.indexOf(document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|") !== -1){
                        document.getElementById("offsystem").value = document.getElementById("offsystem").value.replace(document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|", '');
                    }

                    if(ev.target.getAttribute("name") == "add_device"){
                        //alert(document.getElementById("onsystem").value);

                        //document.getElementById("offsystem").value.replace(document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|", '');
                        document.getElementById("onsystem").value += document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|"
                    }
                    else{

                        document.getElementById("offsystem").value += document.getElementById(data).getElementsByTagName('p')[0].innerHTML +"|"
                    }
                }



        }
    </script>


@endsection
