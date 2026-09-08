@extends('layouts.app')
@section('ext_css')
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/style.css">
@endsection
@section('content')
<section class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Satuan</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Satuan</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($satuan as $key => $satuan)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$satuan->name}}</td>
                            <td>
                                {!! link_to_route('satuan.index', trans('app.edit'), ['action' => 'edit', 'id' => $satuan->id], ['id' => 'edit-satuan-' . $satuan->id]) !!} |
                                {!! link_to_route('satuan.index', trans('app.delete'), ['action' => 'delete', 'id' => $satuan->id], ['id' => 'del-satuan-' . $satuan->id]) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('produk.satuan.form')
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