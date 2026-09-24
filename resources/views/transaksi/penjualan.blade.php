@extends('layouts.app')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3 class="card-title">Transaksi Penjualan</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <form action="{{route('penjualan.add')}}" method="POST" class="xs">
                                    {{csrf_field()}}
                                    <input type="submit" class="btn btn-primary" name="create-sale" id="cash-sale" value="{{ trans('transaction.create') }}">
                                </form>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    use Facades\App\Transaksi\PenjualanCollection;
    @endphp
    @if(PenjualanCollection::isEmpty())
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    Anda belum memiliki Daftar Transaksi, silakan buat Transaksi Baru:
                </h2>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{route('penjualan.add')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-body">
                        <input type="submit" class="btn btn-primary" name="create-sale" id="cash-sale" value="{{ trans('transaction.create') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @includeWhen(!PenjualanCollection::isEmpty(),'transaksi.part.tab-data-penjualan')
    @if($draft)
    @if (Request::get('action') == 'confirm')
    @include('transaksi.part.draft-confirm')
    @else
    <div class="col-8 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>BARANG BELANJA<small>({{$draft->getItemsCount()}} Item, {{$draft->getTotalQty()}} Pcs)</small></h4>
                <hr class="dropdown-divider">
            </div>
            <div class="card-body">
                @include('transaksi.part.draft-item-list')
            </div>
        </div>
    </div>
    <div class="col-4 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>DETAIL TRANSAKSI</h4>
                <hr class="dropdown-divider">
            </div>
            <div class="card-body">
                @include('transaksi.part.form-draft-detail')
            </div>
        </div>
    </div>
    @endif
    @endif
</section>
@endsection