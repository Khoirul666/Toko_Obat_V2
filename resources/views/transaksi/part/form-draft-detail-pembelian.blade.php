{!! Form::open([
'route' => ['pembelian.draft-proccess', $purchased->draftKey],
'method' => 'patch',
'id'=>'purchase-form'
]) !!}
<div id="table-data-list"></div>

<div class="form-group">
    <label for="sales_name">
        {{ trans('transaction.sales_name') }}
    </label>

    <input type="text" name="sales[name]" id="sales_name" class="form-control" value="{{ old('sales.name', $purchased->sales['name'] ?? '') }}" required>
</div>

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label for="sales_phone">
                {{ trans('transaction.sales_phone') }}
            </label>

            <input type="text" name="sales[phone]" id="sales_phone" class="form-control" value="{{ old('sales.phone', $purchased->sales['phone'] ?? '') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="payment">
                {{ trans('transaction.payment') }}
            </label>

            <input type="text" name="payment" id="payment" class="form-control" value="{{ old('payment', $purchased->payment) }}" required>
        </div>
    </div>

</div>

{!! Form::hidden('total', $purchased->getTotal()) !!}

<div class="form-group">
    <label for="notes">
        {{ trans('transaction.notes') }}
    </label>

    <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $purchased->notes) }}</textarea>
</div>

{{ Form::submit(trans('transaction.proccess'), ['class' => 'btn btn-info']) }}

{{ Form::close() }}

@section('script')
<script>

</script>
@endsection