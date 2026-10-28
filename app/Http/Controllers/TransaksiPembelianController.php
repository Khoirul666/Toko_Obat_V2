<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use PDF;

class TransaksiPembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::query();

        // Pencarian nomor transaksi
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', '%' . $search . '%')
                    ->orwhere('sales->name', 'like', '%' . $search . '%');
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

        $purchase = $query
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan.pembelian.index', compact('purchase'));
    }

    public function show(Purchase $purchase)
    {
        return view('laporan.pembelian.show', compact('purchase'));
    }

    public function unduh(Purchase $purchase)
    {   
        $pdf = PDF::loadView('laporan.pembelian.laporan', compact('purchase'));

        $pdf->setPaper('a5','portrait');
        
        return $pdf->download('nota_pembelian-' . $purchase->invoice_no . '.pdf');
    }
}
