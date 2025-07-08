<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_satuan')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Satuan::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('satuan.edit', $row->id);
                    $deleteUrl = route('satuan.destroy', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('satuan.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_satuan')) {
            return $response;
        }

        return view('satuan.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_satuan')) {
            return $response;
        }

        $validated = $request->validate([
            'simbol' => 'required|string|max:50|unique:satuans,simbol',
            'nama' => 'required|string|max:255',
        ]);

        Satuan::create($validated);

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function edit(Satuan $satuan)
    {
        if ($response = $this->checkIzin('akses_master_edit_satuan')) {
            return $response;
        }

        return view('satuan.edit', compact('satuan'));
    }

    public function update(Request $request, Satuan $satuan)
    {
        if ($response = $this->checkIzin('akses_master_edit_satuan')) {
            return $response;
        }

        $validated = $request->validate([
            'simbol' => 'required|string|max:50|unique:satuans,simbol,' . $satuan->id,
            'nama' => 'required|string|max:255',
        ]);

        $satuan->update($validated);

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Satuan $satuan)
    {
        if ($response = $this->checkIzin('akses_master_hapus_satuan')) {
            return $response;
        }

        $satuan->delete();

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
