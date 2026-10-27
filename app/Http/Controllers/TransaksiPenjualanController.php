<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        
        return view('laporan.penjualan.index');
    }
}
