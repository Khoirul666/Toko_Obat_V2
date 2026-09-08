<?php

namespace App\Http\Controllers;

use App\Transaksi\PenjualanCollection;
use App\Transaksi\PenjualanDraft;
use Illuminate\Http\Request;
use App\Penjualan;

class PenjualanController extends Controller
{
    private $keranjang;

    public function __construct()
    {
        $this->keranjang = new PenjualanCollection();
    }

    public function index(Request $request)
    {
        $queriedPenjualan = [];
        $draft = $this->keranjang->content()->first();
        // $keranjang = $this->keranjang;
        // dd($draft, $queriedPenjualan, $this->keranjang->isEmpty(), $keranjang);
        return view('transaksi.penjualan', compact('draft', 'queriedPenjualan'));
    }

    public function add(Request $request)
    {
        // dd($request);
        if ($request->has('create-sale')) {
            $this->keranjang->add(new PenjualanDraft());
        }
        return redirect()->route('penjualan.show', $this->keranjang->content()->last()->draftKey);
    }

    public function show(Request $request, $draftKey)
    {
        $draft = $this->keranjang->get($draftKey);
        if (is_null($draft)) {
            flash(trans('transaction.sale_not_found'), 'danger');

            return redirect()->route('penjualan.index');
        }
        $query = $request->get('query');
        $queryPenjualan = [];
        if ($query) {
            $queryPenjualan = Penjualan::where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })->with('unit')->get();
        }

        return view('transaksi.penjualan', compact('draft', 'queryPenjualan'));
    }

    public function remove(Request $request)
    {
        $this->keranjang->removeDraft($request->draft_key);

        if ($this->keranjang->isEmpty()) {
            return redirect()->route('penjualan.index');
        }

        $lastDraft = $this->keranjang->content()->last();

        return redirect()->route('penjualan.show', $lastDraft->draftKey);
    }
}
