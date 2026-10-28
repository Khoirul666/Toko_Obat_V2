@extends('layouts.app')

@section('ext_css')
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/style.css">
<style>
    #table1 {
        width: 100%;
    }

    #table1 th:last-child,
    #table1 td:last-child {
        width: 1%;
        white-space: nowrap;
    }
</style>
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/dripicons/webfont.css">
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/css/pages/dripicons.css">
@endsection

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Transaksi Penjualan</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('transaksi.penjualan.index') }}" method="get">
                    <div class="col-12 row">
                        <div class="col-4">
                            <input type="text" class="form-control" name="search" placeholder="Cari No TRX/Pelanggan" value="{{ request('search') }}">
                        </div>
                        <div class="col-4 row">
                            <div class="col-6">
                                <input type="date" name="tanggal_awal" class="form-control" placeholder="tanggal awal" value="{{ request('tanggal_awal') }}">
                            </div>
                            <div class="col-6">
                                <input type="date" name="tanggal_akhir" class="form-control" placeholder="tanggal akhir" value="{{ request('tanggal_akhir') }}">
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
                                <th>Transaksi</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penjualan as $key => $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->invoice_no}}</td>
                                <td>{{$item->created_at->format('d/m/y')}}</td>
                                <td>{{$item->customer['name']}}</td>
                                <td>{{format_rp($item->total)}}</td>
                                <td>
                                    <a href="{{ route('transaksi.penjualan.show',$item->invoice_no) }}" class="btn btn-sm btn-outline-primary"><span class="fa-fw select-all fas"></span> Lihat</a>
                                    <a href="{{ route('transaksi.penjualan.download',$item->invoice_no) }}" class="btn btn-sm btn-outline-primary"><span class="icon dripicons-download"></span> Unduh</a>
                                </td>
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