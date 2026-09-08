<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Satuan;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $editableUnit = null;
        $satuan = Satuan::withCount('products')->get();

        if (in_array($request->get('action'), ['edit', 'delete']) && $request->has('id')) {
            $editableUnit = Satuan::find($request->get('id'));
        }
        // dd($satuan, $editableUnit);
        return view('produk.satuan', compact('satuan', 'editableUnit'));
    }

    public function store(Request $request)
    {
        $newUnit = $request->validate([
            'name' => 'required|max:20',
        ]);

        Satuan::create($newUnit);

        flash(trans('satuan.created'), 'success');

        return redirect()->route('satuan.index');
    }

    public function update(Request $request, Satuan $satuan)
    {
        $unitData = $request->validate([
            'name' => 'required|max:20',
        ]);

        $satuan->update($unitData);

        flash(trans('satuan.updated'), 'success');

        return redirect()->route('satuan.index');
    }

    public function destroy(Request $request, Satuan $satuan)
    {
        $this->validate($request, [
            'unit_id' => 'required|exists:satuan,id',
        ]);

        if ($request->get('unit_id') != $satuan->id) {
            flash(trans('satuan.undeleted'), 'error');

            return back();
        }

        if ($satuan->products()->exists()) {
            flash(trans('satuan.undeleteable'), 'error');

            return back();
        }

        $satuan->delete();

        flash(trans('satuan.deleted'), 'success');

        return redirect()->route('satuan.index');
    }
}
