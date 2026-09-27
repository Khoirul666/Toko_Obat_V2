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
        <div class="card-body table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td>{{ trans('transaction.customer_name') }}</td>
                        <td>{{ $draft->customer['name'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('transaction.customer_phone') }}</td>
                        <td>{{ $draft->customer['phone'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('transaction.payment') }}</td>
                        <th class="text-right">{{ format_rp($draft->payment) }}</th>
                    </tr>
                    <tr>
                        <td>{{ trans('transaction.total') }}</td>
                        <th class="text-right">{{ format_rp($draft->getTotal()) }}</th>
                    </tr>
                    <tr>
                        <td>{{ trans('transaction.exchange') }}</td>
                        <th class="text-right">{{ format_rp($draft->getExchange()) }}</th>
                    </tr>
                    <tr>
                        <td>{{ trans('transaction.notes') }}</td>
                        <td>{{ $draft->notes }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ Form::open(['route' => ['penjualan.store', $draft->draftKey]]) }}
            {{ Form::submit(trans('transaction.save'), ['id' => 'save-transaction-draft', 'class' => 'btn btn-success']) }}
            {{ link_to_route('penjualan.show', trans('app.back'), $draft->draftKey, ['class' => 'btn btn-secondary']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>