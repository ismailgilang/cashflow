<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $pemasukanFiltered = $pemasukanFilter->get();
        $pengeluaranFiltered = $pengeluaranFilter->get();

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
            ->get();

        $saldoplus = $pemasukanBulanIni->sum('omset_konter')
            + $pemasukanBulanIni->sum('omset_retail')
            + $pemasukanBulanIni->sum('investor')
            + $pemasukanBulanIni->sum('pemindahan_dana');

        $pengeluaranBulanIni = Pengeluaran::whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
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
            $pemasukan = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
            $pengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();

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

        return view('manager.index', [
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $periode = $request->query('periode', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            $periode = now()->format('Y-m');
        }
        $date = Carbon::parse($periode . '-01');

        $data = Pengeluaran::whereMonth('tanggal', $date->month)
                        ->whereYear('tanggal', $date->year)
                        ->where('status', 'pending')
                        ->get();
        return view('manager.pengeluaran', compact('data'));
    }

    public function create2(Request $request){
        $periode = $request->query('periode', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            $periode = now()->format('Y-m');
        }

        // Lebih aman
        $date = Carbon::parse($periode . '-01');

        $data = Pemasukan::whereMonth('tanggal', $date->month)
                        ->whereYear('tanggal', $date->year)
                        ->where('status', 'pending')
                        ->get();

        return view('manager.pemasukan', compact('data', 'periode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Pemasukan::find($id);
        $data->status = "disetujui";
        $data->update(); // Penting: menyimpan perubahan

        return redirect()->route('manager.create2')->with('success', 'Data berhasil disetujui.');
    }
    public function edit2(string $id)
    {
        $data = Pengeluaran::find($id);
        $data->status = "disetujui";
        $data->update(); // Penting: menyimpan perubahan

        return redirect()->route('manager.create')->with('success', 'Data berhasil disetujui.');
    }

    public function edit21(string $id)
    {
        $data = Pemasukan::find($id);
        $data->status = "ditolak";
        $data->update(); // Penting: menyimpan perubahan

        return redirect()->route('manager.create2')->with('success', 'Data berhasil disetujui.');
    }
    public function edit22(string $id)
    {
        $data = Pengeluaran::find($id);
        $data->status = "ditolak";
        $data->update(); // Penting: menyimpan perubahan

        return redirect()->route('manager.create')->with('success', 'Data berhasil disetujui.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
