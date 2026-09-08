<?php

namespace App\Http\Controllers;

use App\Transaksi\TransaksiCollection;

class DashboardController extends Controller
{
    private $transaksi;
    private $posisi = 'dashboard';

    public function __construct()
    {
        $this->transaksi = new TransaksiCollection();
    }

    public function index()
    {
        $posisi = $this->posisi;
        return view('dashboard', compact('posisi'));
    }
}
