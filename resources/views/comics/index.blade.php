<?php
$headersToShow = ['id', 'title', 'number', 'barcode'];
?>
@extends('layouts.master')

@section('main')
    <h1>Active Comics</h1>

    <p><i class="fa fa-plus" aria-hidden="true"></i>{{ link_to_route('comics.create', 'Add new comic') }}</p>

    @if ($comics->count())
        <table class="table table-striped table-bordered">
            @foreach ($comics as $collNum => $comic)
                @if($collNum === 0)
                    <thead>
                    <tr>
                        @php
                            foreach($comic->toArray() as $header => $value){
                                if( in_array($header,$headersToShow)){
                                    switch($header){
                                        case 'barcode' :
                                        $header = '<i class="fa fa-barcode fa-2x" aria-hidden="true"></i>';
                                        break;
                                        case 'name' :
                                        $header = '<i class="fa fa-user fa-2x" aria-hidden="true"></i>';
                                        break;
                                        case 'title' :
                                        $header = '<i class="fa fa-book fa-2x" aria-hidden="true"></i>';
                                        break;
                                        case 'email':
                                        $header = '<i class="fa fa-envelope fa-2x" aria-hidden="true"></i>';
                                        break;
                                        case 'phone':
                                        $header = '<i class="fa fa-phone fa-2x" aria-hidden="true"></i>';
                                        break;
                                        case 'number':
                                        $header = '<i class="fa fa-bookmark fa-2x" aria-hidden="true"></i>';
                                        break;
                                    }
                                    echo '<th>'.$header.'</th>';
                                }
                            }
                        @endphp
                        <th class="tools" colspan="3"><i class="fa fa-wrench fa-2x" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="{{ count($headersToShow)+3 }}">
                            {{ $comics->links() }}
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    @endif

                    @if($comic->trashed())
                        <tr class="trashed">
                    @else
                        <tr>
                            @endif
                            @foreach($comic->toArray() as $header => $value)
                                @if( in_array($header,$headersToShow))
                                    <td>{{ $value }}</td>
                                @endif
                            @endforeach

                            <td>{{ link_to_route('comics.edit', 'Edit', array($comic->id), array('class' => 'btn btn-info')) }}</td>
                            <td>
                                @if($comic->trashed())
                                    {{ Form::open(array('method' => 'RESTORE', 'route' => array('comics.update', $comic->id))) }}
                                    {{ Form::submit('Restore', array('class' => 'btn')) }}
                                    {{ Form::close() }}
                                @else
                                    {{ Form::open(array('method' => 'DELETE', 'route' => array('comics.destroy', $comic->id))) }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                    {{ Form::close() }}
                                @endif
                            </td>
                            <td>
                                <label for="clientSelectFor{{ $comic->id }}"><i class="fa fa-paperclip fa-2x"
                                                                                data-client="{{  $comic->id }}"
                                                                                aria-hidden="true"></i></label>
                                <select id="clientSelectFor{{ $comic->id }}" class="clientSelector">
                                    <option value='0' data-client="{{  $comic->id }}">
                                        &nbsp;&nbsp;
                                    </option>
                                    @foreach($clients as $client)
                                        <option value='{{ $client->id }}' data-client="{{  $comic->id }}">
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
        </table>
    @else
        There are no comics
    @endif

@stop
@section('style')
    <style>
        html, body {
            background-color: lightblue;
        }

        .addComicTo {

        }
    </style>
@endsection
@section('scriptFooter')
    <script>
        $clientId = 0;
        $comidId = 0;
        $(function () {
            $('.clientSelector').change(function () {
                var selected = $(this).find('option:selected');
                var clientId = selected.data('client');
                var comicId = parseInt($(this).val());

                if (comicId === 0) {
                    $('#addComicTo' + clientId).attr("disabled", "disabled").hide();
                }
                else {
                    $(location).attr('href', '/comics/attach/' + comicId + '/' + clientId);
                }
            });
        });
    </script>
@endsection