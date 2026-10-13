<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiPembelianController extends Controller
{
    public function index(Request $request)
    {
        return view('laporan.pembelian.index');
    }
}
