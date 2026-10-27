<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;

class TransaksiPembelianController extends Controller
{
    public function index(Request $request)
    {
        $purchase = Purchase::get();
        return view('laporan.pembelian.index', compact('purchase'));
    }
}
