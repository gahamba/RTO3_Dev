<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Bootstrap CSS -->

    <link  rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" >
    <link  rel="stylesheet" href="{{ asset('css/bootstrap-grid.css') }}" >
    <link  rel="stylesheet" href="{{ asset('css/bootstrap-reboot.css') }}" >
    <!-- Material Design Bootstrap -->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.2/css/mdb.min.css" rel="stylesheet">-->
    <link  rel="stylesheet" href="{{ asset('css/style.css') }}" >
    <script src="https://cdn.tiny.cloud/1/esl4037olstapcnonfaa1qp75ev8wkvszhpo3rsnhd8e2ju7/tinymce/5/tinymce.min.js"></script>
    <script>tinymce.init({selector:'textarea'});</script>


    <style>
        @import url('https://fonts.googleapis.com/css?family=Anton|Oswald|Patua+One|Signika|Ubuntu+Condensed|Cuprum|Francois+One&display=swap');
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        <!-- Left links panel -->
        <div class="col-sm-2 links_panel_left user_profile_links">


            <div class="d-flex justify-content-center align-items-center user_profile_links">
                <div class="full_user_profile_panel user_profile_links">
                    <!--User profile picture -->
                    <div class="row">
                        <div class="col">
                            <img class="rounded-circle user_profile" src="{{ asset('images/user.png') }}" />
                        </div>

                    </div>
                    <!--User profile picture ends here -->
                    <div class="clear">&nbsp;</div>
                    <div class="row user_profile_links">
                        <!--profile details and icons -->
                        <div class="col">
                            <ul class="list-unstyled">
                                <li><span>{{ auth::user()->name }}</span></li>
                                <li>
                                    <a href="#"><i class="fas fa-cog" data-toggle="tooltip" data-placement="right" title="User Account settings"></i></a>
                                    &nbsp;&nbsp; <a href="#"><i class="fas fa-keyboard" data-toggle="tooltip" data-placement="right" title="Access control"></i></a> &nbsp;&nbsp;
                                    <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt" data-toggle="tooltip" data-placement="right" title="Logout of account"></i></a>
                                </li>
                            </ul>

                        </div>
                        <!--end of profile details and icons -->

                    </div>


                    <div class="clear">&nbsp;</div>
                    <div class="row">

                        <div class="col">
                            <ul class="list-unstyled">
                                <li class="login_link_lists"><span><a href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Takes you to the Dashboard"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a></span></li>
                                <li class="login_link_lists"><span><a href="{{ route('report') }}" data-toggle="tooltip" data-placement="right" title="Generate reports e.g HACCP etc"><i class="fas fa-file-word"></i>&nbsp;Reports</a></span></li>
                                @if(auth::user()->user_type == 0)
                                <li class="login_link_lists"><span><a href="{{ route('system') }}" data-toggle="tooltip" data-placement="right" title="Allows you add systems"><i class="fas fa-layer-group"></i>&nbsp;Systems</a></span></li>
                                <li class="login_link_lists"><span><a href="{{ route('device') }}" data-toggle="tooltip" data-placement="right" title="Allows you add devices"><i class="fas fa-thermometer"></i>&nbsp;Devices</a></span></li>
                                <li class="login_link_lists"><span><a href="{{ route('user') }}" data-toggle="tooltip" data-placement="right" title="Allows you view and add users"><i class="fas fa-user-cog"></i>&nbsp;Users</a></span></li>

                                @endif


                            </ul>

                        </div>


                    </div>
                </div>
            </div>




        </div>
        <!-- Left links panel ends here -->

        <!-- right panel starts here -->
        <div class="col-sm-10">
            <nav class="navbar navbar-light bg-light top_nav_grid">
                <div class="col logo text-hide">
                    &nbsp;realtime-online
                    <!--<img src="images/rto.png" class="img-fluid"  />-->
                </div>
                <span class="float_right_divs w-auto" data-toggle="tooltip" data-placement="right" title="View your direct messages">Messages&nbsp;<a href="{{ route('message') }}"><span class="badge contrast_component2" id="message_content">0</span></a></span>
                <span class="float_right_divs">

                    <span class="col-4 float_right_divs" data-toggle="tooltip" data-placement="right" title="Sign out of your account here"><a href="#"><i class="fas fa-sign-out-alt"></i></a></span>
                    <span class="col-4 float_right_divs"><a href="#"><i class="fas fa-user-circle"></i></a></span>
                    <span class="col-4 float_right_divs">Ahamba...</span>

                </span>



            </nav>






            @yield('content')









        </div>
        <!-- right panel ends here -->

    </div>

</div>



<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.2/js/mdb.min.js"></script>

<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="https://kit.fontawesome.com/f21764ecfb.js"></script>
<script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.24/browser.min.js"></script>
<script src="{{ asset('js/messages.js') }}" defer></script>

<script>
    $( document ).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
    });
</script>

</body>
</html>

