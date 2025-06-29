<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use App\Models\Kode;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->query('periode', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            $periode = now()->format('Y-m');
        }
        $date = Carbon::parse($periode . '-01');

        $data = Pengeluaran::whereMonth('tanggal', $date->month)
                        ->whereYear('tanggal', $date->year)
                        ->get();
        $data2 = Kode::all();
        return view('admin.pengeluaran.index', compact('data', 'data2'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Contoh: simpan ke database jika kamu punya model Kode
        Pengeluaran::create($data);
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $data2 = Kode::all();
        return view('admin.pengeluaran.edit', compact('pengeluaran', 'data2'));
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $kode = Pengeluaran::findOrFail($id); // Ambil data berdasarkan ID
        $kode->update($data); // Update dengan data dari form

        return redirect()->route('Pengeluaran.index')->with('success', 'Data berhasil   diperbarui!');
    }

    public function destroy($id)
    {
        $kode = Pengeluaran::findOrFail($id); // Ambil data berdasarkan ID
        $kode->delete(); // Hapus data

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
