{!! Form::open([
'route' => ['penjualan.draft-proccess', $draft->draftKey],
'method' => 'patch'
]) !!}

<div class="form-group">
    <label for="customer_name">
        {{ trans('transaction.customer_name') }}
    </label>

    <input
        type="text"
        name="customer[name]"
        id="customer_name"
        class="form-control"
        value="{{ old('customer.name', $draft->customer['name'] ?? '') }}"
        required>
</div>

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label for="customer_phone">
                {{ trans('transaction.customer_phone') }}
            </label>

            <input
                type="text"
                name="customer[phone]"
                id="customer_phone"
                class="form-control"
                value="{{ old('customer.phone', $draft->customer['phone'] ?? '') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="payment">
                {{ trans('transaction.payment') }}
            </label>

            <input
                type="text"
                name="payment"
                id="payment"
                class="form-control"
                value="{{ old('payment', $draft->payment) }}"
                required>
        </div>
    </div>

</div>

{!! Form::hidden('total', $draft->getTotal()) !!}

<div class="form-group">
    <label for="notes">
        {{ trans('transaction.notes') }}
    </label>

    <textarea
        name="notes"
        id="notes"
        class="form-control"
        rows="3">{{ old('notes', $draft->notes) }}</textarea>
</div>

{{ Form::submit(trans('transaction.proccess'), [
    'class' => 'btn btn-info'
]) }}

{{ Form::close() }}