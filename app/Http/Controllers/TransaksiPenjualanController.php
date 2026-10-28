<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use PDF;

class TransaksiPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();

        // Pencarian nomor transaksi
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', '%' . $search . '%')
                    ->orwhere('customer->name', 'like', '%' . $search . '%');
            });
        }

        // Filter tanggal awal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->tanggal_awal
            );
        }

        // Filter tanggal akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->tanggal_akhir
            );
        }

        $penjualan = $query
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan.penjualan.index', compact('penjualan'));
    }

    public function show(Transaksi $transaksi)
    {
        return view('laporan.penjualan.show', compact('transaksi'));
    }

    public function unduh(Transaksi $transaksi)
    {
        $pdf = PDF::loadView('laporan.penjualan.laporan', compact('tra$transaksi'));

        $pdf->setPaper('a5', 'portrait');

        return $pdf->download('nota_penjualan-' . $transaksi->invoice_no . '.pdf');
    }
}
