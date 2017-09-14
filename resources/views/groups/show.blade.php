@extends('layouts.master')

@section('main')

    <h1>Show Group</h1>
    {{ Form::model($group, array('method' => 'PATCH', 'route' => array('groups.update', $group->id))) }}
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
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('groups.show', 'Cancel', $group->id, array('class' => 'btn')) }}
        </li>
    </ul>
    {{ Form::close() }}

    @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif

@stop