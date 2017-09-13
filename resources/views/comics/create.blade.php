@extends('layouts.master')

@section('main')

    <h1>Create Comic</h1>
    {{ Form::open(array('route' => 'comics.store')) }}
    <ul>
        <li>
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title') }}
        </li>
        <li>
            {{ Form::label('number', 'Number:') }}
            {{ Form::text('number') }}
        </li>
        <li>
            {{ Form::label('barcode', 'Barcode:') }}
            {{ Form::text('barcode') }}
        </li>
        <li>
            {{ Form::label('notes', 'Notes:') }}
            {{ Form::text('notes') }}
        </li>
        <li>
            {{ Form::submit('Submit', array('class' => 'btn')) }}
        </li>
    </ul>
    {{ Form::close() }}

    @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif

@stop