    <div class="col-8 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ trans('transaction.confirm') }}</h4>
                <hr class="dropdown-divider">
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Item</th>
                            <th class="text-right">Harga Satuan</th>
                            <th class="text-right">Diskon per Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($draft->items() as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-right">{{ format_rp($item->price) }}</td>
                            <td class="text-right">{{ format_rp($item->item_discount) }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-right">{{ format_rp($item->subtotal) }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">{{ trans('transaction.subtotal') }} :</th>
                            <th class="text-right">{{ format_rp($draft->getSubtotal()) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right">{{ trans('transaction.discount_total') }} :</th>
                            <th class="text-right">{{ format_rp($draft->getDiscountTotal()) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right">{{ trans('transaction.total') }} :</th>
                            <th class="text-right">{{ format_rp($draft->getTotal()) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-4 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>{{ trans('transaction.detail') }}</h4>
                <hr class="dropdown-divider">
            </div>
            <div class="card-body">
                <legend>{{ trans('transaction.detail') }}</legend>

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

            </div>
        </div>
    </div>