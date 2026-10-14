<?php

namespace App\Http\Controllers;

use App\Transaksi\PembelianCollection;
use App\Transaksi\PembelianDraft;
use App\Transaksi\Item;
use Illuminate\Http\Request;
use App\Produk;

class PembelianController extends Controller
{

    private $keranjang;

    public function __construct()
    {
        $this->keranjang = new PembelianCollection();
    }

    public function index(Request $request)
    {
        $queriedPembelian = [];
        $purchased = $this->keranjang->content()->first();
        // dd($queriedPembelian, $purchased);
        return view('transaksi.pembelian', compact('purchased', 'queriedPembelian'));
    }

    public function add(Request $request)
    {
        // dd($request);
        if ($request->has('create-sale')) {
            $this->keranjang->add(new PembelianDraft());
        }
        return redirect()->route('pembelian.show', $this->keranjang->content()->last()->draftKey);
    }

    public function show(Request $request, $draftKey)
    {
        $purchased = $this->keranjang->get($draftKey);
        // dd($purchased);
        if (is_null($purchased)) {
            flash(trans('transaction.sale_not_found'), 'danger');

            return redirect()->route('pembelian.index');
        }
        $query = $request->get('query');
        $queriedPembelian = [];
        if ($query) {
            $queriedPembelian = Produk::where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })->with('unit')->get();
        }

        return view('transaksi.pembelian', compact('purchased', 'queriedPembelian'));
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
            return redirect()->route('pembelian.show', [$draftKey, 'query' => $request->get('query')]);
        }

        return back();
    }
    public function proccess(Request $request, $draftKey)
    {
        // dd($request, $draftKey);
        $this->validate($request, [
            'sales.name'     => 'required|string|max:30',
            'sales.phone'    => 'nullable|string|max:20',
            'total'          => 'required|numeric',
            // 'payment'        => 'required|numeric|min:' . $request->get('total') . '|max:' . ($request->get('total') + 100000),
            'payment'        => 'required|numeric|min:' . $request->get('total'),
            'notes'          => 'nullable|string|max:100',
        ], [
            'payment.min' => 'Pembayaran minimal ' . format_rp($request->get('total')) . '.',
            'payment.numeric' => 'Pembayaran harus berupa angka',
        ]);
        $purchased = $this->keranjang->updateDraftAttributes($draftKey, $request->only('sales', 'notes', 'payment'));
        // dd($purchased, 'masuk');
        if ($purchased->getItemsCount() == 0) {
            flash(trans('transaction.item_list_empty'), 'warning')->important();

            return redirect()->route('pembelian.show', [$draftKey]);
        }

        flash(trans('transaction.confirm_instruction', ['back_link' => link_to_route('pembelian.show', trans('app.back'), $draftKey)]), 'warning');

        return redirect()->route('pembelian.show', [$draftKey, 'action' => 'confirm']);
    }

    public function remove(Request $request)
    {
        $this->keranjang->removeDraft($request->draft_key);

        if ($this->keranjang->isEmpty()) {
            return redirect()->route('pembelian.index');
        }

        $lastDraft = $this->keranjang->content()->last();

        return redirect()->route('pembelian.show', $lastDraft->draftKey);
    }

    public function updateDraftItem(Request $request, $draftKey, Produk $product)
    {
        // dd($request, $draftKey, $product);
        $item = new Item($product, $request->qty);
        $item->setItemDiscount($request->item_discount);

        $this->keranjang->UpdateItemToDraft($draftKey, $item);

        flash(trans('cart.item_update', [
            'product_name' => $product->name . ' (' . $product->unit->name . ')',
            'qty'          => $request->qty,
            'discount'     => $request->item_discount,
        ]));

        if ($request->has('query')) {
            return redirect()->route('pembelian.show', [$draftKey, 'query' => $request->get('query')]);
        }

        return back();
        // dd($request, $draftKey, $item);
    }
    public function removeDraftItem(Request $request, $draftKey)
    {
        $this->keranjang->removeItemFromDraft($draftKey, $request->item_index);

        return back();
    }

    public function store(Request $request, $draftKey)
    {
        // dd($request, $draftKey);
        $purchased = $this->keranjang->get($draftKey);
        if (is_null($purchased)) {
            return redirect()->route('pembelian.index');
        }
        // dd($purchased, "store");
        $transaction = $purchased->store();
        // dd($purchased->destroy);
        // dd($transaction);
        $purchased->destroy();
        flash(trans('transaction.created', ['invoice_no' => $transaction->invoice_no]), 'success');

        // return redirect()->route('pembelian.show', $transaction->invoice_no);
        return redirect()->route('pembelian.index');
    }
}
