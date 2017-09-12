<?php
$headersToShow = ['id', 'name', 'barcode'];
?>
@extends('layouts.general')

@section('main')
    <h1>Active Clients</h1>

    <p><i class="fa fa-plus" aria-hidden="true"></i>{{ link_to_route('clients.create', 'Add new client') }}</p>

    @if ($clients->count())
        <table class="table table-striped table-bordered">
            @foreach ($clients as $collNum => $client)
                @if($collNum === 0)
                    <thead>
                    <tr>
                        @php
                            foreach($client->toArray() as $header => $value){
                                if( in_array($header,$headersToShow)){
                                    switch($header){
                                        case 'barcode' :
                                        $header = '<i class="fa fa-barcode fa-2x" aria-hidden="true"></i>';
                                        break;
                                        case 'name' :
                                        $header = '<i class="fa fa-user fa-2x" aria-hidden="true"></i>';
                                        break;
                                        case 'email':
                                        $header = '<i class="fa fa-envelope fa-2x" aria-hidden="true"></i>';
                                        break;
                                        case 'phone':
                                        $header = '<i class="fa fa-phone fa-2x" aria-hidden="true"></i>';
                                        break;
                                    }
                                    echo '<th>'.$header.'</th>';
                                }
                            }
                        @endphp
                        <th colspan="3">Tools</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="{{ count($headersToShow)+3 }}">
                            {{ $clients->links() }}
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    @endif

                    @if($client->trashed())
                        <tr class="trashed">
                    @else
                        <tr>
                            @endif
                            @foreach($client->toArray() as $header => $value)
                                @if( in_array($header,$headersToShow))
                                    <td>{{ $value }}</td>
                                @endif
                            @endforeach

                            <td>{{ link_to_route('clients.edit', 'Edit', array($client->id), array('class' => 'btn btn-info')) }}</td>
                            <td>
                                @if($client->trashed())
                                    {{ Form::open(array('method' => 'RESTORE', 'route' => array('clients.update', $client->id))) }}
                                    {{ Form::submit('Restore', array('class' => 'btn')) }}
                                    {{ Form::close() }}
                                @else
                                    {{ Form::open(array('method' => 'DELETE', 'route' => array('clients.destroy', $client->id))) }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                    {{ Form::close() }}
                                @endif
                            </td>
                            <td>
                                <label for="comicSelectFor{{ $client->id }}"><i class="fa fa-paperclip fa-2x"
                                                                                data-client="{{  $client->id }}"
                                                                                aria-hidden="true"></i></label>
                                <select id="comicSelectFor{{ $client->id }}" class="comicSelector">
                                    <option value='0' data-client="{{  $client->id }}">
                                        &nbsp;
                                    </option>
                                    @foreach($comics as $comic)
                                        <option value='{{ $comic->id }}' data-client="{{  $client->id }}">
                                            {{ $comic->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
        </table>
    @else
        There are no clients
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
            $('.comicSelector').change(function () {
                var selected = $(this).find('option:selected');
                var clientId = selected.data('client');
                var comicId = parseInt($(this).val());

                if (comicId === 0) {
                    $('#addComicTo' + clientId).attr("disabled", "disabled").hide();
                }
                else {
                    $(location).attr('href', '/clients/attach/' + clientId + '/' + comicId);
                }
            });
        });


    </script>
@endsection