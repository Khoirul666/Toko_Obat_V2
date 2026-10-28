<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Penjualan</title>

    <style>
        @page {
            margin: 15px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
            margin: 0;
        }

        .receipt {
            width: 100%;
            padding: 5px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0 18px;
        }

        .dashed-line {
            border-top: 1px dashed #b8c2cc;
            margin: 12px 0;
        }

        .info {
            width: 100%;
            border-collapse: collapse;
            line-height: 1.8;
        }

        .info td {
            padding: 1px 2px;
            vertical-align: top;
        }

        .info .label {
            width: 105px;
        }

        .info .separator {
            width: 12px;
            text-align: center;
        }

        .info .value {
            font-weight: normal;
        }

        .date-right {
            text-align: right;
            white-space: nowrap;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .items th {
            background: #eef3fa;
            color: #172554;
            padding: 9px 5px;
            text-align: left;
            font-size: 9px;
            white-space: nowrap;
        }

        .items td {
            padding: 10px 5px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        .center {
            text-align: center !important;
        }

        .right {
            text-align: right !important;
            white-space: nowrap;
        }

        .summary {
            width: 48%;
            margin-left: 52%;
            margin-top: 12px;
            border-collapse: collapse;
        }

        .summary td {
            padding: 5px 2px;
        }

        .summary .label {
            width: 55%;
        }

        .summary .separator {
            width: 10px;
            text-align: center;
        }

        .summary .value {
            text-align: right;
            white-space: nowrap;
        }

        .summary .total td {
            border-top: 1px solid #ccc;
            font-weight: bold;
            padding-top: 9px;
        }

        .notes {
            width: 100%;
            border-collapse: collapse;
            line-height: 1.8;
        }

        .notes td {
            padding: 3px 2px;
            vertical-align: top;
        }

        .notes .label {
            width: 105px;
        }

        .notes .separator {
            width: 12px;
            text-align: center;
        }

        .notes .value {
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="receipt">

        <div class="title">STRUK PENJUALAN OBAT</div>

        <div class="dashed-line"></div>

        {{-- Informasi transaksi --}}
        <table class="info">
            <tr>
                <td class="label">No. Transaksi</td>
                <td class="separator">:</td>
                <td class="value">
                    <strong>{{ $transaksi->invoice_no }}</strong>
                </td>
                <td class="date-right">
                    {{ optional($transaksi->created_at)->format('d/m/Y') }}
                </td>
            </tr>

            <tr>
                <td class="label">Tanggal</td>
                <td class="separator">:</td>
                <td colspan="2" class="value">
                    {{ optional($transaksi->created_at)->format('d/m/Y H:i') }}
                </td>
            </tr>

            <tr>
                <td class="label">Nama Penjual</td>
                <td class="separator">:</td>
                <td colspan="2" class="value">
                    {{ data_get($transaksi->sales, 'name', '-') }}
                </td>
            </tr>

            <tr>
                <td class="label">Hp/Telp.</td>
                <td class="separator">:</td>
                <td colspan="2" class="value">
                    {{ data_get($transaksi->sales, 'phone', '-') }}
                </td>
            </tr>
        </table>

        <div class="dashed-line"></div>

        {{-- Daftar item --}}
        <table class="items">
            <thead>
                <tr>
                    <th class="center" style="width: 7%;">No.</th>
                    <th style="width: 32%;">Nama Obat</th>
                    <th class="right" style="width: 18%;">Harga Satuan</th>
                    <th class="right" style="width: 15%;">Diskon per Item</th>
                    <th class="center" style="width: 8%;">Qty</th>
                    <th class="right" style="width: 20%;">Subtotal</th>
                </tr>
            </thead>
            @php
            $total_diskon = 0;
            $total_harga = 0;
            @endphp
            <tbody>
                @forelse ($transaksi->items ?? [] as $key => $item)
                @php
                $total_diskon += $item['item_discount_subtotal'];
                $total_harga += $item['subtotal'];
                @endphp
                <tr>
                    <td class="center">{{ $key + 1 }}</td>

                    <td>{{ $item['name'] ?? '-' }}</td>

                    <td class="right">
                        Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="right">
                        {{ number_format($item['item_discount'] ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="center">{{ $item['qty'] ?? 0 }}</td>

                    <td class="right">
                        Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="center">
                        Tidak ada item transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Ringkasan pembayaran --}}
        <table class="summary">
            <tr>
                <td class="label">Subtotal</td>
                <td class="separator">:</td>
                <td class="value">
                    <strong>Rp {{ number_format($total_harga ?? 0, 0, ',', '.') }}</strong>
                </td>
            </tr>

            <tr>
                <td class="label">Total Diskon</td>
                <td class="separator">:</td>
                <td class="value">
                    {{ number_format($total_diskon ?? 0, 0, ',', '.') }}
                </td>
            </tr>

            <tr class="total">
                <td class="label">Total</td>
                <td class="separator">:</td>
                <td class="value">
                    Rp {{ number_format($transaksi->total ?? 0, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td class="label">Jumlah Dibayar</td>
                <td class="separator">:</td>
                <td class="value">
                    Rp {{ number_format($transaksi->payment ?? 0, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td class="label"><strong>Kembalian</strong></td>
                <td class="separator">:</td>
                <td class="value">
                    <strong>
                        Rp {{ number_format($transaksi->payment-$transaksi->total ?? 0, 0, ',', '.') }}
                    </strong>
                </td>
            </tr>
        </table>

        <div class="dashed-line"></div>

        {{-- Catatan transaksi --}}
        <table class="notes">
            <tr>
                <td class="label">Catatan Transaksi</td>
                <td class="separator">:</td>
                <td class="value">
                    {{ $transaksi->notes ?? '-' }}
                </td>
            </tr>
        </table>

    </div>
</body>

</html>