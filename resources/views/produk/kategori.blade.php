@extends('layouts.app')
@section('ext_css')
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/style.css">
@endsection
@section('content')
<section class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Kategori</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $key => $kategori)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$kategori->name}}</td>
                            <td>
                                {!! link_to_route('kategori.index', trans('app.edit'), ['action' => 'edit', 'id' => $kategori->id], ['id' => 'edit-kategori-' . $kategori->id]) !!} |
                                {!! link_to_route('kategori.index', trans('app.delete'), ['action' => 'delete', 'id' => $kategori->id], ['id' => 'del-kategori-' . $kategori->id]) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('produk.kategori.form')
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