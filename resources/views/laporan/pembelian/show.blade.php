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
            <div class="card-body">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3 class="card-title">Detail Transaksi Pembelian</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <a href="{{ route('transaksi.pembelian.index') }}" class="btn btn-sm btn-outline-primary"><span class="icon dripicons-arrow-thin-left"></span> Kembali</a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3 class="card-title">Detail Transaksi Pembelian</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            Tanggal : {{$purchase->created_at}}
                        </nav>
                    </div>
                </div>
                <hr>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <table class="table">
                            <tr>
                                <td>No. Transaksi</td>
                                <td>:</td>
                                <td>{{$purchase->invoice_no}}</td>
                            </tr>
                            <tr>
                                <td>Nama Penjual</td>
                                <td>:</td>
                                <td>{{$purchase->sales['name']}}</td>
                            </tr>
                            <tr>
                                <td>Hp/Telp</td>
                                <td>:</td>
                                <td>{{$purchase->sales['phone']}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table">
                            <tr>
                                <td>Jumlah Dibayar</td>
                                <td>:</td>
                                <td>{{$purchase->payment}}</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>:</td>
                                <td>{{$purchase->total}}</td>
                            </tr>
                            <tr>
                                <td>Kembalian</td>
                                <td>:</td>
                                <td>{{$purchase->payment-$purchase->total}}</td>
                            </tr>
                            <tr>
                                <td>Catatan Transaksi</td>
                                <td>:</td>
                                <td>{{$purchase->notes}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12">
                        @php $total_diskon=0; @endphp
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Obat</th>
                                    <th>Harga Satuan</th>
                                    <th>Diskon Per Item</th>
                                    <th>Qty</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->items as $key => $item)
                                @php
                                $total_diskon +=$item['item_discount_subtotal'];
                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item['name']}}</td>
                                    <td>{{format_rp($item['price'])}}</td>
                                    <td>{{format_rp($item['item_discount'])}}</td>
                                    <td>{{$item['qty']}}</td>
                                    <td class="text-right">{{format_rp($item['subtotal'])}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Subtotal</td>
                                    <td>:</td>
                                    <td>{{$purchase->total}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total Diskon</td>
                                    <td>:</td>
                                    <td>{{$total_diskon}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total</td>
                                    <td>:</td>
                                    <td>{{$purchase->total}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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