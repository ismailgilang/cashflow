<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil request
        $periodeAwal = $request->periode_awal;
        $periodeAkhir = $request->periode_akhir;
        $jenisLaporan = $request->jenis_laporan;

        // Filter berdasarkan periode jika tersedia
        if ($periodeAwal && $periodeAkhir) {
            $startDate = \Carbon\Carbon::parse($periodeAwal)->startOfMonth();
            $endDate = \Carbon\Carbon::parse($periodeAkhir)->endOfMonth();
        } elseif ($periodeAwal && !$periodeAkhir) {
            $startDate = \Carbon\Carbon::parse($periodeAwal)->startOfMonth();
            $endDate = \Carbon\Carbon::parse($periodeAwal)->endOfMonth();
        } elseif (!$periodeAwal && $periodeAkhir) {
            $startDate = \Carbon\Carbon::parse($periodeAkhir)->startOfMonth();
            $endDate = \Carbon\Carbon::parse($periodeAkhir)->endOfMonth();
        } else {
            // Kalau dua-duanya kosong, bisa skip filter
            $startDate = null;
            $endDate = null;
        }

        if ($startDate && $endDate) {
            $queryPemasukan = Pemasukan::whereBetween('created_at', [$startDate, $endDate]);
            $queryPengeluaran = Pengeluaran::whereBetween('created_at', [$startDate, $endDate]);
        } else {
            $queryPemasukan = Pemasukan::query();
            $queryPengeluaran = Pengeluaran::query();
        }

        if (isset($startDate) && isset($endDate)) {
            $queryPemasukan->whereBetween('created_at', [$startDate, $endDate]);
            $queryPengeluaran->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        // Ambil data
        $data = $queryPemasukan->where('status', 'disetujui')->get();
        $data2 = $queryPengeluaran->where('status', 'disetujui')->get();

        $periodeAwal = $startDate ? $startDate->format('d F Y') : null;
        $periodeAkhir = $endDate ? $endDate->format('d F Y') : null;

        // Hitung total omset
        $yogya = $data->sum('omset_konter');
        $retail = $data->sum('omset_retail');

        // Hitung pengeluaran (komponen laporan laba rugi)
        $bahan = $data2->sum('bahan');
        $vendor = $data2->sum('vendor');
        $peralatan = $data2->sum('peralatan');
        $transportasi = $data2->sum('transportasi');
        $biayaKirim = $data2->sum('biaya_kirim');
        $lainLain = $data2->sum('lain_lain');
        $pengeluarankas = $data2->sum('invest');
        $cicilan = $data2->sum('cicilan');
        $refund = $data->sum('refund');
        $pemindahan = $data->sum('pemindahan_dana');

        $omsetretail = $data->sum('omset_retail') + $data->sum('investor') + $data->sum('refund') + $data->sum('pemindahan_dana');

        $gaji = $data2->sum('gaji');
        $operasional = $data2->sum('atk') + $peralatan + $data2->sum('lpti');
        $operasionalLain = $lainLain;

        return view('admin.laporan.index', compact(
            'data',
            'data2',
            'yogya',
            'retail',
            'gaji',
            'operasional',
            'operasionalLain',
            'periodeAwal',
            'periodeAkhir',
            'bahan',
            'transportasi',
            'biayaKirim',
            'vendor',
            'lainLain',
            'pengeluarankas',
            'cicilan',
            'jenisLaporan',
            'omsetretail'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
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
