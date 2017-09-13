@extends('layouts.master')
@section('main')
    @if (count($data) > 0)
        <table class="table table-striped table-bordered">
            @foreach ($data as $collNum => $value)
                @if($collNum === 0)
                    <thead>
                    <tr>
                        <th><i class="fa fa-barcode fa-2x" aria-hidden="true"></i></th>
                        <th><i class="fa fa-book fa-2x" aria-hidden="true"></i></th>
                        <th><i class="fa fa-bookmark fa-2x" aria-hidden="true"></i></th>
                        <th>Total reserved</th>
                        <th>Reserved by</th>
                        <th class="tools" colspan="3"><i class="fa fa-wrench fa-2x" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @endif
                    <tr>
                        <td>{{ $value['barcode'] ?? 'n/a' }}</td>
                        <td>{{ $value['title'] ?? $value['name'] }}</td>
                        <td>{{ $value['number'] ?? 'n/a' }}</td>
                        <td>{{ $value['total'] }}</td>
                        <td>{{ $value['subList'] }}</td>
                        <td></td>

                    </tr>
                    @endforeach
                    </tbody>
        </table>
    @else
        There are no comics
    @endif
@endsection