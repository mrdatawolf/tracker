<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//codeorigin.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
    <title>Tracker10k</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <style>
        body {
            background-color: #eeeeee;
            color: #000;
            font-family: 'Tahoma', sans-serif;
            font-weight: bold;
            height: 100vh;
            margin: 0;
            /*background: url(images/ncrp.jpg) no-repeat center center fixed;
            -webkit-background-size: contain;
            -moz-background-size: contain;
            -o-background-size: contain;
            background-size: contain;*/
        }
        html {
            min-width: 1024px;
            min-height: 700px;
        }
        a {
            color: #000;
            font-weight: bold;
        }
        ul {
            list-style-type: none;
        }

        tr {
            padding-bottom: .25em;
            vertical-align: middle;
        }
        th, td {
            text-align: center;
        }
        .full-height {
            min-height: 700px;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }

        .top-menu {
            background-color: #fff;
            position: fixed;
            right: .25em;
            top: .25em;
        }
        .content {
            text-align: center;
        }
        .title {
            font-size: 84px;
        }
        .links > a {
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        #home_image {
            max-height: 4em;
            vertical-align: top;
        }

        .alert {
            position: absolute;
            left: .25em;
        }
        .alert-error {
            top: 1.25em;
            background-color: red;
        }

        .alert-success {
            top: 3.5em;
            background-color: lawngreen;
        }

        .flash {
            top: 5.75em;
            background-color: lawngreen;
        }
        .trashed {
            font-weight: 300;
        }
        .fa-stack {
            margin-bottom: 1em;
        }

        .subList a {
            color: #aa0000;
        }

        .addNew {
            color: green;
        }

        #menubar {
            font-size: 6pt;
            margin: .1em;
            padding: .1em;
        }

        .subUl {
            display: -moz-box;
            display: -webkit-box;
            display: box;
            max-width: 120em;
        }

        .subLi {
            -moz-box-flex: 1;
            -webkit-box-flex: 1;
            box-flex: 1;
            padding: .2em;
            margin: .1em;
        }
    </style>
    @yield('style')
</head>
<body>
<div class="flex-center position-ref full-height">
    <div id="menubar" class="top-menu links">
        <a href="{{ url('/') }}"><img id="home_image" title="home" src="/images/ncrp.jpg"></a>
        <a href="{{ url('/clients') }}"><i class="fa fa-users fa-4x" aria-hidden="true"></i></a>
        <a href="{{ url('/comics') }}"><i class="fa fa-book fa-4x" aria-hidden="true"></i></a>
        <a href="{{ url('/groups') }}"><i class="fa fa-exchange fa-4x" aria-hidden="true"></i></a>
        <a href="{{ url('/clients/balancesheet') }}">
            <span class="fa-stack fa-2x">
            <i class="fa fa-users fa-stack-2x" aria-hidden="true"></i>
            <i class="fa fa-balance-scale fa-inverse fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>
        <a href="{{ url('/comics/balancesheet') }}">
            <span class="fa-stack fa-2x">
            <i class="fa fa-book fa-stack-2x" aria-hidden="true"></i>
            <i class="fa fa-balance-scale fa-inverse fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>
        <a href="{{ url('/comics/wishlist') }}">
            <span class="fa-stack fa-2x">
            <i class="fa fa-leaf fa-stack-2x" aria-hidden="true"></i>
            <i class="fa fa-balance-scale fa-inverse fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>
        <a href="{{ url('/groups/balancesheet') }}">
            <span class="fa-stack fa-2x">
            <i class="fa fa-exchange fa-stack-2x" aria-hidden="true"></i>
            <i class="fa fa-balance-scale fa-inverse fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>
    </div>
    <div class="container">
        @if (Session::has('message'))
            <div class="flash alert">
                <p>{{ Session::get('message') }}<i id="flash-off" class="alert-close fa fa-times-circle"></i></p>
            </div>
        @endif
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}<i id="success-off" class="alert-close fa fa-times-circle"></i></p>
            </div><br/>
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-error">
                <p>{{ \Session::get('error') }}<i id="error-off" class="alert-close fa fa-times-circle"></i></p>
            </div><br/>
        @endif

        @yield('main')
    </div>
</div>

<script>
    $('.alert-close').click(function () {
        $(this).parent().parent().fadeOut();
    });
</script>
@yield('scriptFooter')
</body>

</html>