<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::latest()->first();
        // dd($setting);
        return view('setting.index', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'stok' => 'required|integer|min:0',
        ]);
        // dd($data['stok']);
        $setting->update([
            'value' => $data['stok'],
        ]);
        // dd($setting);
        return redirect()->back()->with('success', 'Pengaturan stok berhasil diperbarui');
    }
}
