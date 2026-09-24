<table class="table table hover mb-0">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Item</th>
            <th>Harga Satuan</th>
            <th class="text-right">Diskon per Item</th>
            <th class="text-center">Qty</th>
            <th class="text-right">Subtotal</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($draft->items() as $key => $item)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>
                {{ $item->name }} <br>
                <small class="text-primary">({{ $item->unit }})</small>
            </td>
            <td>{{ format_rp($item->price) }}</td>
            {{ Form::open(['route' => ['penjualan.update-draft-item', $draft->draftKey], 'method' => 'patch']) }}
            {{ Form::hidden('item_key', $key) }}
            <td class="text-right">
                {{ Form::text('item_discount', $item->item_discount, ['id' => 'item_discount-' . $key,'style' => 'width:80px;text-align:right']) }}
            </td>
            <td class="text-center">
                {{ Form::number('qty', $item->qty, ['id' => 'qty-' . $key,'style' => 'width:50px;text-align:center','min' => 1]) }}
            </td>
            <td class="text-right">{{ format_rp($item->subtotal) }}</td>
            {{ Form::submit('update-item-' . $key, ['style'=>'display:none']) }}
            {{ Form::close() }}
            <td class="text-center show-on-hover-parent">

                {!! Form::open([
                'route' => ['penjualan.remove-draft-item', $draft->draftKey],
                'method' => 'delete',
                'onsubmit' => "return confirm('Yakin ingin menghapus Item ini?')"
                ]) !!}

                {!! Form::hidden('item_index', $key) !!}

                {!! Form::submit('x', [
                'id' => 'remove-item-' . $key,
                'class' => 'btn btn-danger btn-xs show-on-hover',
                'title' => 'Hapus item ini'
                ]) !!}

                {!! Form::close() !!}

            </td>
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" class="text-right">{{ trans('transaction.subtotal') }} :</th>
            <th class="text-right">{{ format_rp($draft->getSubtotal()) }}</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="5" class="text-right">{{ trans('transaction.discount_total') }} :</th>
            <th class="text-right">{{ format_rp($draft->getDiscountTotal()) }}</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="5" class="text-right">{{ trans('transaction.total') }} :</th>
            <th class="text-right">{{ format_rp($draft->getTotal()) }}</th>
            <th></th>
        </tr>
    </tfoot>
</table>