@extends('layouts.app')

@section('ext_css')
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/style.css">
<style>
    :root {
        --primary-one: #1b269e;
        --primary-two: #db9004;
        --primary-three: #13db04;
    }

    .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        padding: 8px;
        box-sizing: border-box;
    }

    .one {
        background-color: color-mix(in srgb, var(--primary-one) 12%, white)
    }

    .two {
        background-color: color-mix(in srgb, var(--primary-two) 12%, white)
    }

    .three {
        background-color: color-mix(in srgb, var(--primary-three) 12%, white)
    }

    svg {
        width: 24px;
        height: 24px;
    }

    .content-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
@endsection

@section('content')
<section class="row">
    <div class="col-4 col-lg-4">
        <div class="card">
            <div class="card-body px-3 py-4-5" style="color:var(--primary-one)">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Total Kategori Obat</h6>
                        <h2 class="font-extrabold mb-0">{{$data['kategori']}}</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-circle one">
                            <svg class="bi" width="1em" height="1em" fill="currentColor">
                                <use
                                    xlink:href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/bootstrap-icons/bootstrap-icons.svg#box" />
                            </svg>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content-wrapper">
                    <div class="icon-wrapper">
                        <svg class="bi" width="1em" height="1em" fill="currentColor">
                            <use
                                xlink:href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/bootstrap-icons/bootstrap-icons.svg#check-circle" />
                        </svg>
                    </div>
                    <div class="text-content">
                        Kategori Obat Tedaftar
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4 col-lg-4">
        <div class="card">
            <div class="card-body px-3 py-4-5" style="color:var(--primary-two)">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Stok Obat Menipis</h6>
                        <h2 class="font-extrabold mb-0">{{$data['jumlahProduk']}}</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-circle two">
                            <svg class="bi" width="1em" height="1em">
                                <use
                                    xlink:href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/bootstrap-icons/bootstrap-icons.svg#exclamation-triangle" />
                            </svg>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content-wrapper">
                    <div class="icon-wrapper">
                        <svg class="bi" width="1em" height="1em">
                            <use
                                xlink:href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/bootstrap-icons/bootstrap-icons.svg#exclamation-circle" />
                        </svg>
                    </div>
                    <div class="text-content">
                        Perlu segera dilakukan pemesanan ulang
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4 col-lg-4">
        <div class="card">
            <div class="card-body px-3 py-4-5" style="color:var(--primary-three)">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Total Stok Obat</h6>
                        <h2 class="font-extrabold mb-0">{{$data['stok']}}</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-circle three">
                            <svg class="bi" width="1em" height="1em" fill="currentColor">
                                <use
                                    xlink:href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/bootstrap-icons/bootstrap-icons.svg#archive" />
                            </svg>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content-wrapper">
                    <div class="icon-wrapper">
                        <svg class="bi" width="1em" height="1em" fill="currentColor">
                            <use
                                xlink:href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/bootstrap-icons/bootstrap-icons.svg#clipboard-check" />
                        </svg>
                    </div>
                    <div class="text-content">
                        Total Keseluruhan unti obat tersedia
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Daftar Obat dengan Stok Menipis</h4>
                    <h6>Obat yang perlu mendapatkan perhatian untuk menjaga ketersediaan stok</h6>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['produk'] as $key=>$item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->kategori->name}}</td>
                            <td>{{$item->stok}}</td>
                            <td>{{$item->unit->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
@endsection

@push('ext_js')
<script src="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="{{asset('mazer-1.0.0/dist')}}/assets/js/pages/dashboard.js"></script>
@endpush