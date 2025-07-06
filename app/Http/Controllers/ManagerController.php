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
    public function index()
    {
        return view('manager.index');
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

    public function edit12(string $id)
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
