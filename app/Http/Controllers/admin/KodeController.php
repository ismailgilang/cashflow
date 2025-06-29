<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kode;
use Illuminate\Http\Request;

class KodeController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = Kode::query();

        // Paginate & bawa kembali query string (search) di link halaman
        $data = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kode.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Contoh: simpan ke database jika kamu punya model Kode
        Kode::create($data);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $kode = Kode::findOrFail($id);
        return view('admin.kode.edit', compact('kode'));
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $kode = Kode::findOrFail($id); // Ambil data berdasarkan ID
        $kode->update($data); // Update dengan data dari form

        return redirect()->route('Kode.index')->with('success', 'Data berhasil   diperbarui!');
    }

    public function destroy($id)
    {
        $kode = Kode::findOrFail($id); // Ambil data berdasarkan ID
        $kode->delete(); // Hapus data

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
