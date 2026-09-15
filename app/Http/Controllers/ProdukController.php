<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Satuan;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $editableProduct = null;
        $satuan = Satuan::all();
        $produk = Produk::orderBy('name')
            ->with('unit')->get();

        if (in_array($request->get('action'), ['edit', 'delete']) && $request->has('id')) {
            $editableProduct = Produk::find($request->get('id'));
        }
        // dd($produk); 
        return view('produk.produk', compact('produk', 'editableProduct', 'satuan'));
    }

    public function store(Request $request)
    {
        $newProduct = $request->validate([
            'name'         => 'required|max:20',
            'price'        => 'required|numeric',
            'unit_id'      => 'required|numeric|exists:satuan,id',
        ]);

        Produk::create($newProduct);

        flash(trans('produk.created'), 'success');

        return redirect()->route('produk.index');
    }

    public function update(Request $request, Produk $produk)
    {

        $productData = $request->validate([
            'name'         => 'required|max:20',
            'price'        => 'required|numeric',
            'unit_id'      => 'required|numeric|exists:satuan,id',
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
