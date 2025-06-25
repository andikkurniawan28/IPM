<?php

namespace App\Http\Controllers;

use App\Models\TitikPengamatan;
use Illuminate\Http\Request;

class UbahUrutanTitikPengamatanController extends Controller
{
    public function index()
    {
        $titik_pengamatans = TitikPengamatan::all();
        return view('ubah_urutan_titik_pengamatan.index', compact('titik_pengamatans'));
    }

    public function process(Request $request)
    {
        $urutanBaru = json_decode($request->urutan_baru, true);

        if (is_array($urutanBaru)) {
            // Reset semua urutan ke null
            TitikPengamatan::query()->update(['urutan' => null]);

            // Simpan urutan baru
            foreach ($urutanBaru as $index => $id) {
                TitikPengamatan::where('id', $id)->update(['urutan' => $index + 1]);
            }
        }

        return redirect()->route('titik_pengamatan.index')->with('success', 'Urutan berhasil diperbarui.');
    }
}
