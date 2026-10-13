<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Satuan;
use App\Kategori;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $editableProduct = null;
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        $produk = Produk::orderBy('name')
            ->with('unit')->get();

        if (in_array($request->get('action'), ['edit', 'delete']) && $request->has('id')) {
            $editableProduct = Produk::find($request->get('id'));
        }
        // dd($produk); 
        return view('produk.produk', compact('produk', 'editableProduct', 'satuan', 'kategori'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $newProduct = $request->validate([
            'name'         => 'required|max:20',
            'price'        => 'required|numeric',
            'sell'         => 'required|numeric',
            'unit_id'      => 'required|numeric|exists:satuan,id',
            'kategori_id'  => 'required|numeric|exists:kategori,id',
        ]);

        // dd($newProduct);
        Produk::create($newProduct);

        flash(trans('produk.created'), 'success');

        return redirect()->route('produk.index');
    }

    public function update(Request $request, Produk $produk)
    {
        // dd($request);
        $productData = $request->validate([
            'name'         => 'required|max:20',
            'price'        => 'required|numeric',
            'sell'        => 'required|numeric',
            'unit_id'      => 'required|numeric|exists:satuan,id',
            'kategori_id'      => 'required|numeric|exists:kategori,id',
        ]);

        $produk->update($productData);

        flash(trans('produk.updated'), 'success');

        return redirect()->route('produk.index',);
    }

    public function destroy(Request $request, Produk $produk)
    {
        // dd($request);
        $requestData = $request->validate([
            'product_id' => 'required|exists:produk,id',
        ]);


        if ($requestData['product_id'] == $produk->id && $produk->delete()) {
            flash(trans('produk.deleted'), 'success');

            return redirect()->route('produk.index');
        }

        flash(trans('produk.undeleted'), 'error');

        return back();
    }
}
