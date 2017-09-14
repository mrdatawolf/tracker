<?php
$headersToShow = ['id', 'title', 'number', 'barcode'];
?>
@extends('layouts.master')

@section('main')
    <h1>Active Comics</h1>

    <p class="addNew"><i class="fa fa-plus" aria-hidden="true"></i>{{ link_to_route('comics.create', 'Add new comic') }}</p>

    @if ($comics->count())
        <table class="table table-striped table-bordered">
            @foreach ($comics as $collNum => $comic)
                @if($collNum === 0)
                    <thead>
                    <tr>
                        <th><i class="fa fa-barcode fa-2x" title="barcode number" aria-hidden="true"></i></th>
                        <th><i class="fa fa-book fa-2x" aria-hidden="true"></i></th>
                        <th><i class="fa fa-bookmark fa-2x" aria-hidden="true"></i></th>
                        <th class="tools" colspan="2"><i class="fa fa-wrench fa-2x" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="4">
                            {{ $comics->links() }}
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    @endif
                        <tr>
                            <td>{{$comic->barcode}}</td>
                            <td>{{$comic->title}} {{ link_to_route('comics.edit', 'Edit', array($comic->id), array('class' => 'btn btn-info')) }}</td>
                            <td>{{$comic->number}}</td>
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
                            <td>
                                @if($comic->trashed())
                                    {{ link_to_route('clients.update', 'Restore', array($client->id), array('class' => 'btn btn-info')) }}
                                @else
                                    {{ Form::open(array('method' => 'DELETE', 'route' => array('comics.destroy', $comic->id))) }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                    {{ Form::close() }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
        </table>
    @else
        There are no comics
    @endif

@stop
@section('scriptFooter')
    <script>
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