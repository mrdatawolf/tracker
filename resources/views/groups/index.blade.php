@extends('layouts.master')

@section('main')
    <h1>Active Groups</h1>

    <p class="addNew"><i class="fa fa-plus" aria-hidden="true"></i>{{ link_to_route('groups.create', 'Add new group') }}</p>

    @if ($groups->count())
        <table class="table table-striped table-bordered">
            @foreach ($groups as $collNum => $group)
                @if($collNum === 0)
                    <thead>
                    <tr>
                        <th><i class="fa fa-barcode fa-2x" title="barcode number" aria-hidden="true"></i></th>
                        <th><i class="fa fa-link fa-2x" title="group title" aria-hidden="true"></i></th>
                        <th class="tools" colspan="2"><i class="fa fa-wrench fa-2x" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="4">
                            {{ $groups->links() }}
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    @endif
                    <tr>
                        <td>{{ $group->barcode }}</td>
                        <td>{{ $group->title }}
                            {{ link_to_route('groups.edit', 'Edit', array($group->id), array('class' => 'btn btn-info')) }}
                        </td>

                        <td>
                            <label for="groupSelectFor{{ $group->id }}">
                                <i class="fa fa-paperclip fa-2x" data-group="{{  $group->id }}"
                                   aria-hidden="true"></i>
                            </label>
                            <select id="groupSelectFor{{ $group->id }}" class="comicSelector">
                                <option value='0' data-group="{{  $group->id }}">
                                    &nbsp;
                                </option>
                                @foreach($comics as $comic)
                                    <option value='{{ $comic->id }}' data-group="{{  $group->id }}">
                                        {{ $comic->title }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            @if($group->trashed())
                                {{ link_to_route('groups.update', 'Restore', array($group->id), array('class' => 'btn btn-info')) }}
                            @else
                                {{ Form::open(['method' => 'DELETE', 'route' => array('groups.destroy', $group->id)]) }}
                                {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                {{ Form::close() }}
                            @endif
                        </td>
                    @endforeach
                    </tbody>
        </table>
    @else
        There are no groups
    @endif
@stop
@section('scriptFooter')
    <script>
        $(function () {
            $('.comicSelector').change(function () {
                var selected = $(this).find('option:selected');
                var groupId = selected.data('group');
                var comicId = parseInt($(this).val());

                if (comicId !== 0) {
                    $(location).attr('href', '/groups/attach/' + groupId + '/' + comicId);
                }
            });
        });
    </script>
@endsection