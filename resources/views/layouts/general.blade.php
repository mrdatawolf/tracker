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
        html, body {
            background-color: #fff;
            color: #000000;
            font-family: 'Raleway', sans-serif;
            font-weight: bold;
            height: 100vh;
            margin: 0;
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

        a {
            color: #000000;
            font-weight: bold;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none;
        }

        #home_image {
            max-height: 2em;
            max-width: 3em;
        }

        th, td {
            text-align: center;
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
    </style>
    @yield('style')
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="top-right links">
        <a href="{{ url('/') }}"><img id="home_image" src="/images/ncrp.jpg"></a>
        <a href="{{ url('/clients') }}"><i class="fa fa-users" aria-hidden="true"></i></a>
        <a href="{{ url('/comics') }}"><i class="fa fa-book" aria-hidden="true"></i></a>
    <!--<a href="{{ url('/watchlists') }}"><i class="fa fa-binoculars" aria-hidden="true"></i></a>
        <a href="{{ url('/orders') }}">Orders</a>
        <a href="{{ url('/notes') }}">Notes</a>-->
        <a href="{{ url('/groups') }}"><i class="fa fa-exchange" aria-hidden="true"></i></a>
        <a href="{{ url('/comic_count') }}"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
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