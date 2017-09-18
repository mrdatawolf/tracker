<?php
$headersToShow = ['id', 'name', 'barcode'];
?>
@extends('layouts.master')

@section('main')
    <h1>Active Clients</h1>

    <p class="addNew"><i class="fa fa-plus" aria-hidden="true"></i>{{ link_to_route('clients.create', 'Add new client') }}</p>

    @if ($clients->count())
        <table class="table table-striped table-bordered">
            @foreach ($clients as $collNum => $client)
                @if($collNum === 0)
                    <thead>
                    <tr>
                        <th><i class="fa fa-barcode fa-2x" title="barcode number" aria-hidden="true"></i></th>
                        <th><i class="fa fa-user fa-2x" aria-hidden="true"></i></th>
                        <th class="tools" colspan="2"><i class="fa fa-wrench fa-2x" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            {{ $clients->links() }}
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    @endif
                    <tr>
                        <td>{{ $client->barcode }}</td>
                        <td>{{ $client->name }}
                            {{ link_to_route('clients.edit', 'Edit', array($client->id), array('class' => 'btn btn-info')) }}
                        </td>

                        <td>
                            <label for="comicSelectFor{{ $client->id }}">
                                <i class="fa fa-paperclip fa-2x" data-client="{{  $client->id }}"
                                   aria-hidden="true"></i>
                            </label>
                            <select id="comicSelectFor{{ $client->id }}" class="comicSelector">
                                <option value='0' data-client="{{  $client->id }}">
                                    &nbsp;
                                </option>
                                @foreach($comics as $comic)
                                    <option value='{{ $comic->id }}' data-client="{{  $client->id }}">
                                        {{ $comic->title }}:{{ $comic->number }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            @if($client->trashed())
                                {{ link_to_route('clients.update', 'Restore', array($client->id), array('class' => 'btn btn-info')) }}
                            @else
                                {{ Form::open(['method' => 'DELETE', 'route' => array('clients.destroy', $client->id)]) }}
                                {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                {{ Form::close() }}
                            @endif
                        </td>
                    @endforeach
                    </tbody>
        </table>
    @else
        There are no clients
    @endif

@stop
@section('scriptFooter')
    <script>
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