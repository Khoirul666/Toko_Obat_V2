@extends('layouts.app')
@section('ext_css')
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/style.css">
@endsection
@section('content')
<section class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Produk</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('app.table_no') }}</th>
                            <th>{{ __('produk.name') }}</th>
                            <th>{{ __('produk.unit') }}</th>
                            <th class="text-right">{{ __('produk.price') }}</th>
                            <th class="text-center">{{ __('app.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $key => $produk)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$produk->name}}</td>
                            <td class="text-right">{{$produk->unit->name}}</td>
                            <td class="text-right">{{format_rp($produk->price)}}</td>
                            <td class="text-center">
                                {!! link_to_route('produk.index', trans('app.edit'), ['action' => 'edit', 'id' => $produk->id], ['id' => 'edit-produk-' . $produk->id]) !!} |
                                {!! link_to_route('produk.index', trans('app.delete'), ['action' => 'delete', 'id' => $produk->id], ['id' => 'del-produk-' . $produk->id]) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('produk.produk.form')
</section>
@endsection
@push('ext_js')
<script src="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/simple-datatables.js"></script>
@endpush
@section('script')
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
@endsection