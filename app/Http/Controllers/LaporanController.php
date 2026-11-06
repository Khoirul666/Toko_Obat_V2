<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = DB::table('purchase')
            ->selectRaw('YEAR(created_at) as tahun')
            ->union(
                DB::table('transaksi')
                    ->selectRaw('YEAR(created_at) as tahun')
            )
            ->orderBy('tahun', 'desc')
            ->get();

        $data = [
            'tahun' => $tahun
        ];
        // dd($data);
        return view('laporan.laporan.index', compact('data'));
    }

    public function bulan(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = DB::table('purchase')
            ->selectRaw('MONTH(created_at) as bulan')
            ->whereYear('created_at', $tahun)
            ->union(
                DB::table('transaksi')
                    ->selectRaw('MONTH(created_at) as bulan')
                    ->whereYear('created_at', $tahun)
            )
            ->orderBy('bulan', 'asc')
            ->get();
        return response()->json($bulan);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|min:1|max:12',
        ]);

        $tahun = $request->tahun;
        $bulan = $request->bulan;

        // Awal dan akhir bulan
        $awalBulan = Carbon::createFromDate($tahun, $bulan, 1)
            ->startOfMonth();

        $akhirBulan = $awalBulan->copy()->endOfMonth();

        // 1. Mengambil total pemasukan per tanggal
        $pemasukan = DB::table('transaksi')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
            ->whereBetween('created_at', [
                $awalBulan,
                $akhirBulan
            ])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('tanggal');

        // 2. Mengambil total pengeluaran per tanggal
        $pengeluaran = DB::table('purchase')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
            ->whereBetween('created_at', [
                $awalBulan,
                $akhirBulan
            ])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('tanggal');

        // 3. Membuat rekap seluruh tanggal
        $laporan = [];

        $saldo = 0;

        for ($i = 1; $i <= $awalBulan->daysInMonth; $i++) {

            $tanggal = $awalBulan->copy()
                ->addDays($i - 1)
                ->format('Y-m-d');

            // Ambil pemasukan, jika tidak ada isi 0
            $totalPemasukan = $pemasukan->has($tanggal)
                ? $pemasukan->get($tanggal)->total
                : 0;

            // Ambil pengeluaran, jika tidak ada isi 0
            $totalPengeluaran = $pengeluaran->has($tanggal)
                ? $pengeluaran->get($tanggal)->total
                : 0;

            // Hitung saldo berjalan
            $saldo += $totalPemasukan - $totalPengeluaran;

            $laporan[] = [
                'tanggal' => $tanggal,
                'pemasukan' => (float) $totalPemasukan,
                'pengeluaran' => (float) $totalPengeluaran,
                'saldo' => $saldo,
            ];
        }

        // Total
        $totalPemasukan = $pemasukan->sum('total');
        $totalPengeluaran = $pengeluaran->sum('total');

        return response()->json([
            'laporan' => $laporan,
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,
        ]);
    }
}
