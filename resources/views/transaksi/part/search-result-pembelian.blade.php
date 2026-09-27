<div class="card-footer">
    <table class="table table hover mb-0">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Pilihan Pembelian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($queriedPembelian as $produk)
            <tr>
                <td>{{$produk->name}}</td>
                <td>{{$produk->unit->name}}</td>
                <td>{{$produk->stok}}</td>
                <td>{{format_rp($produk->price)}}</td>
                <td>
                    <form action="{{ route('pembelian.add-draft-item', [$draftKey, $produk->id]) }}" method="post" style="display:inline">
                        <input type="hidden" name="query" value="{{ isset($query) ? $query : request('query') }}">
                        <input type="hidden" name="_token" value="{{ isset($formToken) ? $formToken : csrf_token() }}">
                        <input type="number" id="qty-{{ $produk->id }}" style="width:50px" name="qty" value="1" min="1">
                        <input type="submit" id="add-produk-{{ $produk->id }}" value="Tambah">
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">
                    Produk tidak ditemukan dengan keyword : <strong><em>{{ request('query') }}</em></strong>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>