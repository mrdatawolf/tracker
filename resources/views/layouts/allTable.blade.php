<h1>All {{ $plural }}</h1>

<p><i class="fa fa-plus" aria-hidden="true"></i>{{ link_to_route($plural.'.create', 'Add new '.$singular) }}</p>

@if ($$plural->count())
    <table class="table table-striped table-bordered">
        @foreach ($$plural as $collNum => $$singular)

            @if($collNum === 0)
                <thead>
                @foreach($$singular->toArray() as $header => $value)
                    <th>{{ $header }}</th>
                @endforeach
                <th colspan="2">Tools</th>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="{{ count($$singular->toArray())+2 }}">
                        {{ $$plural->links() }}
                    </td>
                </tr>
                </tfoot>
                <tbody>
                @endif

                @if($$singular->trashed())
                    <tr class="trashed">
                @else
                    <tr>
                        @endif
                        @foreach($$singular->toArray() as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                        <td>{{ link_to_route('clients.edit', 'Edit', array($$singular->id), array('class' => 'btn btn-info')) }}</td>
                        <td>
                            {{ Form::open(array('method' => 'DELETE', 'route' => array('clients.destroy', $$singular->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
    </table>
@else
    There are no clients
@endif
