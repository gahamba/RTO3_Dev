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

        <span class="badge badge-danger">Critical</span>


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

</body>
