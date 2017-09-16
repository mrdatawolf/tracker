@extends('layouts.master')

@section('main')

    <h1>Edit Comic</h1>
    {{ Form::model($comic, array('method' => 'PATCH', 'route' => array('comics.update', $comic->id))) }}
    <ul>
        <li>
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title') }}
        </li>
        <li>
            {{ Form::label('barcode', 'Barcode:') }}
            {{ Form::text('barcode') }}
        </li>
        <li>
            {{ Form::label('number', 'Number:') }}
            {{ Form::text('number') }}
        </li>
        <li>
            {{ Form::label('notes', 'Notes:') }}
            {{ Form::text('notes') }}
        </li>
        <li>
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('comics.show', 'Cancel', $comic->id, array('class' => 'btn')) }}
        </li>
    </ul>
    {{ Form::close() }}

    @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif

@stop