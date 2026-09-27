<?php

namespace App\Http\Controllers;

use App\Transaksi\PenjualanCollection;
use App\Transaksi\PenjualanDraft;
use App\Transaksi\Item;
use Illuminate\Http\Request;
use App\Produk;

class PenjualanController extends Controller
{
    private $keranjang;

    public function __construct()
    {
        $this->keranjang = new PenjualanCollection();
    }

    public function index(Request $request)
    {
        $queryPenjualan = [];
        $draft = $this->keranjang->content()->first();
        // $keranjang = $this->keranjang;
        // dd($draft, $queriedPenjualan, $this->keranjang->isEmpty(), $keranjang);
        return view('transaksi.penjualan', compact('draft', 'queryPenjualan'));
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
            $queryPenjualan = Produk::where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })->with('unit')->get();
        }
        // dd($queryPenjualan);
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
    public function addDraftItem(Request $request, $draftKey, Produk $product)
    {
        // dd($request, $draftKey, $product);
        $item = new Item($product, $request->qty);
        $this->keranjang->addItemToDraft($draftKey, $item);

        flash(trans('cart.item_added', [
            'product_name' => $product->name . ' (' . $product->unit->name . ')',
            'qty'          => $request->qty,
        ]));

        if ($request->has('query')) {
            return redirect()->route('penjualan.show', [$draftKey, 'query' => $request->get('query')]);
        }

        return back();
    }
    public function removeDraftItem(Request $request, $draftKey)
    {
        $this->keranjang->removeItemFromDraft($draftKey, $request->item_index);

        return back();
    }

    public function proccess(Request $request, $draftKey)
    {
        // dd($request, $draftKey);
        $this->validate($request, [
            'customer.name'  => 'required|string|max:30',
            'customer.phone' => 'nullable|string|max:20',
            'total'          => 'required|numeric',
            'payment'        => 'required|numeric|min:' . $request->get('total') . '|max:' . ($request->get('total') + 100000),
            'notes'          => 'nullable|string|max:100',
        ], [
            'payment.min' => 'Pembayaran minimal ' . format_rp($request->get('total')) . '.',
            'payment.max' => 'Pembayaran terlalu besar ' . format_rp($request->get('payment')) . '.',
        ]);
        $draft = $this->keranjang->updateDraftAttributes($draftKey, $request->only('customer', 'notes', 'payment'));

        if ($draft->getItemsCount() == 0) {
            flash(trans('transaction.item_list_empty'), 'warning')->important();

            return redirect()->route('penjualan.show', [$draftKey]);
        }

        flash(trans('transaction.confirm_instruction', ['back_link' => link_to_route('penjualan.show', trans('app.back'), $draftKey)]), 'warning');

        return redirect()->route('penjualan.show', [$draftKey, 'action' => 'confirm']);
    }
}
