@extends('layouts.general')

@section('main')
    <?php
    $singular = 'comic';
    $plural = 'comics';
    ?>
    @include('layouts.allTable')
@stop
@section('style')
    <style>
        html, body {
            background-color: lightcoral;
        }
    </style>
@endsection