@extends('layouts.app')
@section('ext_css')
<link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/style.css">
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pengaturan Minimum Stok</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" method="POST" action="{{route('setting.update',$setting->id)}}">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Minimal Stok</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="stok" class="form-control" name="stok" placeholder="Stok Minimal" value="{{$setting->value}}">
                                </div>
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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