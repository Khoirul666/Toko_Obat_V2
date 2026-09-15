<div class="col-4">
    <div class="card">
        <div class="card-body">
            @if (! Request::has('action'))
            {{ link_to_route('satuan.index', trans('satuan.create'), ['action' => 'create'], ['class' => 'btn btn-success pull-right']) }}
            @endif
            @if (Request::get('action') == 'create')
            {!! Form::open(['route' => 'satuan.store']) !!}
            <div class="form-group">
                <label for="name">{{ trans('satuan.name') }}</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required>
            </div>
            {!! Form::submit(trans('satuan.create'), ['class' => 'btn btn-success']) !!}
            {{ link_to_route('satuan.index', trans('app.cancel'), [], ['class' => 'btn btn-secondary']) }}
            {!! Form::close() !!}
            @endif
            @if (Request::get('action') == 'edit' && $editableUnit)
            {!! Form::model($editableUnit, ['route' => ['satuan.update', $editableUnit->id],'method' => 'patch']) !!}
            <div class="form-group">
                <label for="name">{{ trans('satuan.name') }}</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ old('name', $editableUnit->name) }}"
                    required>
            </div>
            {!! Form::submit(trans('satuan.update'), ['class' => 'btn btn-success']) !!}
            {{ link_to_route('satuan.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
            {!! Form::close() !!}
            @endif
            @if (Request::get('action') == 'delete' && $editableUnit)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('satuan.delete') }}</h3>
                </div>
                <div class="panel-body">
                    <label class="control-label">{{ trans('satuan.name') }}</label>
                    <p>{{ $editableUnit->name }}</p>
                    {!! $errors->first('unit_id', '<span class="form-error small">:message</span>') !!}
                    <hr>
                    {{ trans('satuan.delete_confirm') }}
                </div>
                <div class="panel-footer">
                    {!! Form::open([
                    'route' => ['satuan.destroy', $editableUnit->id],
                    'method' => 'delete'
                    ]) !!}

                    {!! Form::hidden('unit_id', $editableUnit->id) !!}

                    {!! Form::submit(
                    trans('app.delete_confirm_button'),
                    ['class' => 'btn btn-danger']
                    ) !!}

                    {!! Form::close() !!}
                    {{ link_to_route('satuan.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>