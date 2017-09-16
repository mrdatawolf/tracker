@extends('layouts.master')
@section('main')
    <h1>{{  $balanceTitle }}</h1>
    @if (count($data) > 0)
        <table class="table table-striped table-bordered">
            @foreach ($data as $collNum => $value)
                @if($collNum === 0)
                    <thead>
                    <tr>
                        <th><i class="fa fa-barcode fa-2x" aria-hidden="true"></i></th>
                        @if($subListTitle === 'Clients')
                            <th><i class="fa fa-book fa-2x" aria-hidden="true"></i></th>
                            <th><i class="fa fa-bookmark fa-2x" aria-hidden="true"></i></th>
                        @else
                            <th><i class="fa fa-user fa-2x" aria-hidden="true"></i></th>
                        @endif
                        <th>Total waiting reserves</th>
                        <th>{{ $subListTitle }} (click check to mark as fullfilled for client)
                        </th>
                        <th class="tools" colspan="3"><i class="fa fa-wrench fa-2x" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @endif
                    <tr>
                        <td>{{ $value['barcode'] ?? 'n/a' }}</td>
                        <td>{{ $value['title'] ?? $value['name'] }}</td>
                        @if($subListTitle === 'Clients')
                        <td>{{ $value['number'] ?? 'n/a' }}</td>
                        @endif
                        <td>{{ $value['total'] }}</td>
                        <td id="subList">{!! $value['subList'] !!}</td>
                        <td></td>

                    </tr>
                    @endforeach
                    </tbody>
        </table>
    @else
        There are no comics
    @endif
@endsection