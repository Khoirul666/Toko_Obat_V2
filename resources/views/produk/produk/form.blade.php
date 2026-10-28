<div class="col-4">
    <div class="card">
        <div class="card-body">
            {{ link_to_route('produk.index', __('produk.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}
        </div>
    </div>
    <div class="card">
        @if (Request::get('action') == 'create')
        {!! Form::open(['route' => 'produk.store']) !!}
        <div class="card-body">
            <div class="form-group">
                <label for="name">{{__('produk.name')}}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" required>
            </div>
            <div class="form-group">
                <label for="price">{{__('produk.price')}}</label>
                <input type="text" name="price" id="price" class="form-control" value="{{old('price')}}" required>
            </div>
            <div class="form-group">
                <label for="sell">{{__('produk.sell')}}</label>
                <input type="text" name="sell" id="sell" class="form-control" value="{{old('sell')}}" required>
            </div>
            <div class="form-group">
                <label for="unit_id">{{__('produk.unit')}}</label>
                <select name="unit_id" id="unit_id" class="form-control" required>
                    @foreach($satuan as $satuan)
                    <option value="{{ $satuan->id }}" {{ old('unit_id', optional($editableProduct)->unit_id) == $satuan->id ? 'selected' : '' }}>
                        {{ $satuan->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="kategori_id">{{__('produk.kategori')}}</label>
                <select name="kategori_id" id="kategori_id" class="form-control" required>
                    @foreach($kategori as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id', optional($editableProduct)->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            {!! Form::submit(__('produk.create'), ['class' => 'btn btn-success']) !!}
            {{ link_to_route('produk.index', __('app.cancel'), [], ['class' => 'btn btn-secondary']) }}
            {!! Form::close() !!}
        </div>
        @endif
        @if (Request::get('action') == 'edit' && $editableProduct)
        <div class="card-body">
            {!! Form::model($editableProduct, ['route' => ['produk.update', $editableProduct->id],'method' => 'patch']) !!}
            <div class="form-group">
                <label for="name">{{__('produk.name')}}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name',$editableProduct->name)}}" required>
            </div>
            <div class="form-group">
                <label for="price">{{__('produk.price')}}</label>
                <input type="text" name="price" id="price" class="form-control" value="{{old('price',$editableProduct->price)}}" required>
            </div>
            <div class="form-group">
                <label for="sell">{{__('produk.sell')}}</label>
                <input type="text" name="sell" id="sell" class="form-control" value="{{old('sell',$editableProduct->sell)}}" required>
            </div>
            <div class="form-group">
                <label for="stok">{{__('produk.stok')}}</label>
                <input type="text" name="stok" id="stok" class="form-control" value="{{old('stok',$editableProduct->stok)}}" required>
            </div>
            <div class="form-group">
                <label for="unit_id">{{__('produk.unit')}}</label>
                <select name="unit_id" id="unit_id" class="form-control" required>
                    @foreach($satuan as $satuan)
                    <option value="{{ $satuan->id }}" {{ old('unit_id', optional($editableProduct)->unit_id) == $satuan->id ? 'selected' : '' }}>
                        {{ $satuan->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="kategori_id">{{__('produk.kategori')}}</label>
                <select name="kategori_id" id="kategori_id" class="form-control" required>
                    @foreach($kategori as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id', optional($editableProduct)->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            {!! Form::submit(__('produk.update'), ['class' => 'btn btn-success']) !!}
            {{ link_to_route('produk.index', __('app.cancel'),[], ['class' => 'btn btn-secondary']) }}
            {!! Form::close() !!}
        </div>
        @endif
        @if (Request::get('action') == 'delete' && $editableProduct)
        <div class="card-body">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ __('produk.delete') }}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <th>{{ __('produk.name') }}</th>
                                <td>{{ $editableProduct->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('produk.unit') }}</th>
                                <td>{{ $editableProduct->unit->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('produk.price') }}</th>
                                <td>{{ format_rp($editableProduct->price) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    {{ __('produk.delete_confirm') }}
                </div>
                <div class="panel-footer">
                    {!! Form::open([
                    'route' => ['produk.destroy', $editableProduct->id],
                    'method' => 'delete'
                    ]) !!}

                    {!! Form::hidden('product_id', $editableProduct->id) !!}

                    {!! Form::submit(
                    __('app.delete_confirm_button'),
                    ['class' => 'btn btn-danger']
                    ) !!}

                    {{ link_to_route('produk.index', __('app.cancel'), Request::only('q'), ['class' => 'btn btn-secondary']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>