<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Produk;
use App\Setting;
use App\Transaksi\TransaksiCollection;

class DashboardController extends Controller
{
    public function index()
    {
        $minimumStok = Setting::where('key', 'minimum_stok')->value('value');
        $produk = Produk::where('stok', '<=', $minimumStok);
        $kategori = Kategori::count();
        $stok = Produk::sum('stok');
        $data = [
            'produk' => $produk->get(),
            'jumlahProduk' => $produk->count(),
            'kategori' => $kategori,
            'stok' => $stok,
        ];
        return view('dashboard', compact('data'));
    }
}
