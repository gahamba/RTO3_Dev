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

        <!-- Left links panel ends here -->

        <!-- right panel starts here -->
        <div class="col-sm p-0" id="main">
            <nav class="navbar navbar-light bg-light top_nav_grid p-2">

                <div class="col logo text-hide">
                    &nbsp;realtime-online
                    <!--<img src="images/rto.png" class="img-fluid"  />-->
                </div>

                <span class="float_right_divs">

                    <span class="col-4 float_right_divs" data-toggle="tooltip" data-placement="right" title="Sign out of your account here"><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i></a></span>
                    <span class="col-4 float_right_divs"><a href="#"><i class="fas fa-user-circle"></i></a></span>
                    <span class="col-4 float_right_divs">{{ explode(' ', substr(auth::user()->name, 0, 6))[0] }}..</span>

                </span>



            </nav>






            @yield('content')









        </div>
        <!-- right panel ends here -->

    </div>

</div>
<div id="loading_overlay" style="z-index:10000;background-color:#000;opacity:0.5;display:none;cursor:wait;">
    <div style="z-index:10001;background-color:#FFF;opacity:1;cursor:auto;position:absolute;top:50%;left:50%;height:300px;width:300px;margin-top:-150px;margin-left:-150px;">Please wait, loading...</div>
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



<script>
    function openNav() {
        x =  document.getElementsByClassName("link_text");
        y =  document.getElementsByClassName("icon");
        z =  document.getElementsByClassName("mySidebar");
        if(x.style.display === "block"){
            x.style.display === "none";
            if (y.classList) {
                y.classList.toggle("col-sm-6");
            } else {
                // For IE9
                var classes = y.className.split(" ");
                var i = classes.indexOf("col-sm-6");

                if (i >= 0)
                    classes.splice(i, 1);
                else
                    classes.push("col-sm-6");
                y.className = classes.join(" ");
            }
            if (z.classList) {
                z.classList.toggle("col-sm-1");
            } else {
                // For IE9
                var classes = z.className.split(" ");
                var i = classes.indexOf("col-sm-1");

                if (i >= 0)
                    classes.splice(i, 1);
                else
                    classes.push("col-sm-1");
                z.className = classes.join(" ");
            }
        }
        else{
            x.style.display === "block"
        }
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
    }
</script>
<script>
    $('#openbtn').click(function() {

        $('.link_text').toggle();
        $('.icon').toggleClass("col-sm-6")
        //$('#main').toggleClass("col-11", 300);
        //$('#mySidebar').toggleClass("col-1", 300);
        //$('#mySidebar').removeClass("col-sm-2");
        $('#mySidebar').toggleClass("col-sm-1");
        //$('#sidebarContent').css("width", "auto");

        /*$('#mySidebar').animate({
            width: '30%'
        }, 350);
*/
        /*if ($(window).width() > 500) { //your chosen mobile res
            $('.text').toggle(300);
        } else {
            $('.menu').animate({
                width: 'toggle'
            }, 350);
        }*/
    });

    $('#openbtnmobile').click(function() {


        $('#mySidebar').toggle();

    });
</script>
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

