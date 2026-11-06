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
                <h3 class="card-title">Data Laporan Keuangan</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Filter Periode</h4>
            </div>
            <div class="card-body">
                <form id="filterForm">
                    @csrf
                    <div class="col-12 row">
                        <div class="col-4 form-group has-icon-left">
                            <label for="first-name-icon">Tahun</label>
                            <select name="tahun" id="tahun" class="form-select">
                                <option value="" selected>---</option>
                                @foreach($data['tahun'] as $key => $tahun)
                                <option value="{{$tahun->tahun}}">{{$tahun->tahun}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 form-group has-icon-left">
                            <label for="first-name-icon">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select">
                                <option value="" selected>---</option>
                            </select>
                        </div>
                        <div class="col-4 form-group has-icon-left">
                            <label for="first-name-icon">&nbsp;</label>
                            <button type="submit" class="form-control btn btn-primary"><span class="fa-fw select-all fas"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col-4">
                                    <div class="stats-icon" style="background-color: #FFF;">
                                        <img src="{{asset('mazer-1.0.0/dist')}}/assets/images/increase.png" alt="" width="100%">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <h6 class="text-muted font-semibold">Total Pemasukan</h6>
                                    <h6 class="font-extrabold mb-0" id="tPemasukan"></h6>
                                </div>
                            </div>

                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-4">
                                    <div class="stats-icon" style="background-color: #FFF;">
                                        <img src="{{asset('mazer-1.0.0/dist')}}/assets/images/decrease.png" alt="" width="100%">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <h6 class="text-muted font-semibold">Total Pengeluaran</h6>
                                    <h6 class="font-extrabold mb-0" id="tPengeluaran"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-4">
                                    <div class="stats-icon" style="background-color: #FFF;">
                                        <img src="{{asset('mazer-1.0.0/dist')}}/assets/images/wallet.png" alt="" width="100%">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <h6 class="text-muted font-semibold">Saldo</h6>
                                    <h6 class="font-extrabold mb-0" id="saldo"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pemasukan (Rp)</th>
                                <th>Pengeluaran (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('mazer-1.0.0/dist')}}/assets/vendors/simple-datatables/simple-datatables.js"></script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);

    // Format Rupiah
    function formatRupiah(angka) {
        return "Rp. " + new Intl.NumberFormat('id-ID').format(
            Number(angka) || 0
        );
    }

    $('#filterForm').submit(function(e) {
        e.preventDefault();

        let tahun = $('#tahun').val();
        let bulan = $('#bulan').val();

        if (!tahun || !bulan || bulan === "none") {
            alert('Silakan pilih tahun dan bulan terlebih dahulu!');
            return;
        }

        $.ajax({
            url: "{{ route('transaksi.laporan.filter') }}",
            type: "GET",
            data: {
                tahun: tahun,
                bulan: bulan
            },
            dataType: "json",
            beforeSend: function() {
                $('#table1 tbody').html(
                    '<tr><td colspan="6">Memuat data...</td></tr>'
                );
            },
            success: function(data) {

                // Hapus DataTable lama
                dataTable.destroy();

                // Kosongkan isi tabel
                let tbody = document.querySelector('#table1 tbody');
                tbody.innerHTML = '';

                if (data.length === 0) {

                    tbody.innerHTML =
                        '<tr><td colspan="6">Data tidak ditemukan</td></tr>';

                } else {
                    // console.log(data)
                    // Tampilkan total pemasukan
                    $('#tPemasukan').text(
                        formatRupiah(data.total_pemasukan)
                    );

                    // Tampilkan total pengeluaran
                    $('#tPengeluaran').text(
                        formatRupiah(data.total_pengeluaran)
                    );

                    $('#saldo').text(
                        formatRupiah(data.saldo)
                    )

                    data.laporan.forEach(function(item) {
                        // console.log(item)
                        let tr = document.createElement('tr');

                        let tanggal = new Date(item.tanggal + 'T00:00:00');

                        let tanggalFormat = tanggal.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                        let values = [
                            tanggalFormat,
                            formatRupiah(item.pemasukan),
                            formatRupiah(item.pengeluaran),
                        ];

                        values.forEach(function(value) {
                            let td = document.createElement('td');
                            td.textContent = value ?? '';
                            tr.appendChild(td);
                        });

                        tbody.appendChild(tr);
                    });
                }

                // Inisialisasi kembali DataTable
                dataTable = new simpleDatatables.DataTable(table1);
            },
            error: function(xhr) {

                console.log(xhr.responseText);

                alert('Terjadi kesalahan saat mengambil data laporan.');

                dataTable.destroy();

                document.querySelector('#table1 tbody').innerHTML = '';

                dataTable = new simpleDatatables.DataTable(table1);
            }
        })
    });

    $(document).ready(function() {
        $('#tahun').change(function() {
            var tahun = $(this).val();
            $('#bulan').html('<option value="none" selected>---</option>');

            if (tahun) {
                $.ajax({
                    url: "{{route('transaksi.laporan.bulan')}}",
                    type: "GET",
                    data: {
                        tahun: tahun
                    },
                    success: function(data) {
                        $('#bulan').empty();
                        $('#bulan').append(
                            '<option value="none" selected>---</option>'
                        );

                        var namaBulan = [
                            'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember'
                        ];

                        $.each(data, function(key, value) {
                            $('#bulan').append(
                                '<option value="' + value.bulan + '">' + namaBulan[value.bulan - 1] + '</option>'
                            );
                        });
                    }

                })
            } else {
                $('#bulan').html(
                    '<option value="">Pilih Bulan</option>'
                );
            }
        });
    });
</script>
@endsection