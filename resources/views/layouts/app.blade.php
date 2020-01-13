<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <link  rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}" >
    <link  rel="stylesheet" href="{{ URL::asset('css/bootstrap-grid.css') }}" >
    <link  rel="stylesheet" href="{{ URL::asset('css/bootstrap-reboot.css') }}" >
    <link  rel="stylesheet" href="{{ URL::asset('css/style.css') }}" >

    <style>
        @import url('https://fonts.googleapis.com/css?family=Anton|Oswald|Nunito|Titillium+Web|Patua+One|Signika|Ubuntu+Condensed|Cuprum|Francois+One&display=swap');
    </style>
</head>
<body>




<div class="container-fluid">
    <div class="row">

        <div class="col-sm-8 panel_left">


        </div>
        <div class="col-sm-4 full_height_container login_panel_right">
            <div class="h-100 d-flex justify-content-center align-items-center">

                <div class="container-fluid">
                    <!--logo div-->

                    <div class="col logo text-hide">
                        &nbsp;realtime-online
                        <!--<img src="images/rto.png" class="img-fluid"  />-->
                    </div>


                    <div class="clear">&nbsp;</div>



            @yield('content')




                </div>
            </div>
        </div>

    </div>

</div>





<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="{{ URL::asset('js/bootstrap.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.bundle.js') }}"></script>
<script src="https://kit.fontawesome.com/f21764ecfb.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5e1c379c7e39ea1242a45313/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->

</body>
</html>

