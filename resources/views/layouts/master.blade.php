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
            color: #000000;
            font-family: 'Raleway', sans-serif;
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
            background-color: #fff;
        }

        a {
            color: #000000;
            font-weight: bold;
        }

        ul {
            list-style-type: none;
        }

        th, td {
            text-align: center;
        }

        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
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
            max-height: 5em;
            max-width: 8em;
            margin-bottom: 2em;
        }
        .alert-error {
            background-color: red;
        }
        .alert-success {
            background-color: lawngreen;
        }
        .trashed {
            font-weight: 300;
        }
        .fa-stack {
            margin-bottom: 1em;
        }

        #subList a {
            color: #aa0000;
        }

        .addNew {
            color: green;
        }
    </style>
    @yield('style')
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="top-right links">
        <a href="{{ url('/') }}"><img id="home_image" src="/images/ncrp.jpg"></a>
        <a href="{{ url('/clients') }}"><i class="fa fa-users fa-4x" aria-hidden="true"></i></a>
        <a href="{{ url('/comics') }}"><i class="fa fa-book fa-4x" aria-hidden="true"></i></a>
        <a href="{{ url('/groups') }}"><i class="fa fa-exchange fa-4x" aria-hidden="true"></i></a>
        <a href="{{ url('/comics/balancesheet') }}">
            <span class="fa-stack fa-2x">
            <i class="fa fa-book fa-stack-2x" aria-hidden="true"></i>
            <i class="fa fa-balance-scale fa-inverse fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>
        <a href="{{ url('/clients/balancesheet') }}">
            <span class="fa-stack fa-2x">
            <i class="fa fa-users fa-stack-2x" aria-hidden="true"></i>
            <i class="fa fa-balance-scale fa-inverse fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>
    </div>
    <div class="container">
        @if (Session::has('message'))
            <div class="flash alert">
                <p>{{ Session::get('message') }}</p>
            </div>
        @endif
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br/>
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-error">
                <p>{{ \Session::get('error') }}</p>
            </div><br/>
        @endif

        @yield('main')
    </div>
</div>

@yield('scriptFooter')
</body>

</html>