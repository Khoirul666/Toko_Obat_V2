<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $editableUnit = null;
        $kategori = Kategori::withCount('products')->get();

        if (in_array($request->get('action'), ['edit', 'delete']) && $request->has('id')) {
            $editableUnit = Kategori::find($request->get('id'));
        }
        // dd($kategori, $editableUnit);
        return view('produk.kategori', compact('kategori', 'editableUnit'));
    }

    public function store(Request $request)
    {
        $newUnit = $request->validate([
            'name' => 'required|max:20',
        ]);

        Kategori::create($newUnit);

        flash(trans('kategori.created'), 'success');

        return redirect()->route('kategori.index');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $unitData = $request->validate([
            'name' => 'required|max:20',
        ]);

        $kategori->update($unitData);

        flash(trans('kategori.updated'), 'success');

        return redirect()->route('kategori.index');
    }

    public function destroy(Request $request, Kategori $kategori)
    {
        $this->validate($request, [
            'unit_id' => 'required|exists:kategori,id',
        ]);

        if ($request->get('unit_id') != $kategori->id) {
            flash(trans('kategori.undeleted'), 'error');

            return back();
        }

        if ($kategori->products()->exists()) {
            flash(trans('kategori.undeleteable'), 'error');

            return back();
        }

        $kategori->delete();

        flash(trans('kategori.deleted'), 'success');

        return redirect()->route('kategori.index');
    }
}
