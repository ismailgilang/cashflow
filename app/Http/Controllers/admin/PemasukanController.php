<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\Kode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->query('periode', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            $periode = now()->format('Y-m');
        }

        // Lebih aman
        $date = Carbon::parse($periode . '-01');

        $data = Pemasukan::whereMonth('tanggal', $date->month)
                        ->whereYear('tanggal', $date->year)
                        ->get();

        $data2 = Kode::all();

        return view('admin.pemasukan.index', compact('data', 'data2', 'periode'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Contoh: simpan ke database jika kamu punya model Kode
        Pemasukan::create($data);
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $data2 = Kode::all();
        return view('admin.pemasukan.edit', compact('pemasukan', 'data2'));
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $kode = Pemasukan::findOrFail($id); // Ambil data berdasarkan ID
        $kode->update($data); // Update dengan data dari form

        return redirect()->route('Pemasukan.index')->with('success', 'Data berhasil   diperbarui!');
    }

    public function destroy($id)
    {
        $kode = Pemasukan::findOrFail($id); // Ambil data berdasarkan ID
        $kode->delete(); // Hapus data

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
