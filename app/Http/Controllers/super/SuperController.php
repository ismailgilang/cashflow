<?php

namespace App\Http\Controllers\super;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuperController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $now = Carbon::now();

        // ========= SALDO (Total) DENGAN FILTER =========
        $pemasukanFilter = Pemasukan::query();
        $pengeluaranFilter = Pengeluaran::query();

        if ($filter === 'bulan') {
            $start = $now->copy()->startOfMonth();
            $end = $now->copy()->endOfMonth();
            $pemasukanFilter->whereBetween('tanggal', [$start, $end]);
            $pengeluaranFilter->whereBetween('tanggal', [$start, $end]);
        } elseif ($filter === 'triwulan') {
            // Dari 2 bulan sebelumnya hingga bulan ini
            $start = $now->copy()->subMonths(2)->startOfMonth();
            $end = $now->copy()->endOfMonth();
            $pemasukanFilter->whereBetween('tanggal', [$start, $end]);
            $pengeluaranFilter->whereBetween('tanggal', [$start, $end]);
        } elseif ($filter === 'tahun') {
            // Dari awal tahun hingga sekarang
            $start = $now->copy()->startOfYear();
            $end = $now->copy()->endOfYear(); // atau now langsung juga bisa
            $pemasukanFilter->whereBetween('tanggal', [$start, $end]);
            $pengeluaranFilter->whereBetween('tanggal', [$start, $end]);
        }
        // Jika filter kosong atau tidak dikenali => semua data (tanpa where)

        // Eksekusi query
        $pemasukanFiltered = $pemasukanFilter->where('status', 'disetujui')->get();
        $pengeluaranFiltered = $pengeluaranFilter->where('status', 'disetujui')->get();

        $totalPemasukan = $pemasukanFiltered->sum('omset_konter')
            + $pemasukanFiltered->sum('omset_retail')
            + $pemasukanFiltered->sum('investor')
            + $pemasukanFiltered->sum('pemindahan_dana');

        $totalPengeluaran = $pengeluaranFiltered->sum('gaji')
            + $pengeluaranFiltered->sum('biaya_kirim')
            + $pengeluaranFiltered->sum('transportasi')
            + $pengeluaranFiltered->sum('lpti')
            + $pengeluaranFiltered->sum('atk')
            + $pengeluaranFiltered->sum('bahan')
            + $pengeluaranFiltered->sum('peralatan')
            + $pengeluaranFiltered->sum('lain_lain')
            + $pengeluaranFiltered->sum('invest')
            + $pengeluaranFiltered->sum('vendor')
            + $pengeluaranFiltered->sum('profit')
            + $pengeluaranFiltered->sum('cicilan')
            + $pengeluaranFiltered->sum('pajak')
            + $pengeluaranFiltered->sum('pemindahan');

        $saldo = $totalPemasukan - $totalPengeluaran;

        // ========= SALDO PLUS dan MINUS BULAN INI (tidak tergantung filter) =========
        $pemasukanBulanIni = Pemasukan::whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->where('status', 'disetujui')
            ->get();

        $saldoplus = $pemasukanBulanIni->sum('omset_konter')
            + $pemasukanBulanIni->sum('omset_retail')
            + $pemasukanBulanIni->sum('investor')
            + $pemasukanBulanIni->sum('pemindahan_dana');

        $pengeluaranBulanIni = Pengeluaran::whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->where('status', 'disetujui')
            ->get();

        $saldominus = $pengeluaranBulanIni->sum('gaji')
            + $pengeluaranBulanIni->sum('biaya_kirim')
            + $pengeluaranBulanIni->sum('transportasi')
            + $pengeluaranBulanIni->sum('lpti')
            + $pengeluaranBulanIni->sum('atk')
            + $pengeluaranBulanIni->sum('bahan')
            + $pengeluaranBulanIni->sum('peralatan')
            + $pengeluaranBulanIni->sum('lain_lain')
            + $pengeluaranBulanIni->sum('invest')
            + $pengeluaranBulanIni->sum('vendor')
            + $pengeluaranBulanIni->sum('profit')
            + $pengeluaranBulanIni->sum('cicilan')
            + $pengeluaranBulanIni->sum('pajak')
            + $pengeluaranBulanIni->sum('pemindahan');

        // ========= LABEL PERIODE UNTUK VIEW =========
        $periode = match ($filter) {
            'bulan'     => 'Bulan Ini (' . $now->translatedFormat('F Y') . ')',
            'triwulan'  => '3 Bulan Terakhir - s.d ' . $now->translatedFormat('F Y'),
            'tahun'     => 'Tahun ' . $now->year,
            default     => 'Keseluruhan Data',
        };

        $tahun = Carbon::now()->year;
        $bulanSekarang = Carbon::now()->month;

        $dataLabaRugi = collect();

        foreach (range(1, 12) as $bulan) {
            $pemasukan = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'disetujui')->get();
            $pengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'disetujui')->get();

            $labaRugi = ($pemasukan->sum("omset_konter") - $pemasukan->sum("omset_retail"))
                    - ($pemasukan->sum("omset_konter") + $pemasukan->sum("omset_retail"))
                    - ($pengeluaran->sum("gaji") + $pengeluaran->sum("atk") + $pengeluaran->sum("lpti") + $pengeluaran->sum("lain_lain"));

            $dataLabaRugi->push([
                'bulan' => Carbon::create()->month($bulan)->format('M'),
                'nilai' => $labaRugi
            ]);

            // Simpan nilai bulan sekarang
            if ($bulan == $bulanSekarang) {
                $labaRugiBulanIni = $labaRugi;
            }
        }

        return view('super.index', [
            'saldo' => $saldo,
            'saldoplus' => $saldoplus,
            'saldominus' => $saldominus,
            'filter' => $filter,
            'periode' => $periode,
            'labaRugiBulanIni' => $labaRugiBulanIni ?? 0,
            'labels' => $dataLabaRugi->pluck('bulan'),
            'dataLabaRugi' => $dataLabaRugi->pluck('nilai'),
        ]);
    }
}
