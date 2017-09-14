@extends('layouts.master')

@section('main')
    <h1>Create Group</h1>
    {{ Form::open(array('route' => 'groups.store')) }}
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
@section('scriptFooter')
    <script>
        $('#title').focus();
    </script>
@endsection