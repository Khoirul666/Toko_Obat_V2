@extends('layouts.app')

@section('ext_css')
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/style.css">
@endsection

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Transaksi Pembelian</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="col-12 row">
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="Cari No TRX/Pelanggan">
                        </div>
                        <div class="col-4 row">
                            <div class="col-6">
                                <input type="date" class="form-control" placeholder="tanggal awal">
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" placeholder="tanggal akhir">
                            </div>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary"><span class="fa-fw select-all fas"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Sales</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchase as $key => $item)
                            <tr>
                                <td>{{$item->invoice_no}}</td>
                                <td>{{$item->created_at->format('d/m/y')}}</td>
                                <td>{{$item->total}}</td>
                                <td>{{$item->total}}</td>
                                <td>{{$item->total}}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/simple-datatables.js"></script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
@endsection