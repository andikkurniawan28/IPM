<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ZonaController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_zona')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Zona::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $monitoringUrl = route('monitoring_per_zona.index', $row->id);
                    $editUrl = route('zona.edit', $row->id);
                    $deleteUrl = route('zona.destroy', $row->id);
                    return '
                        <a target="_blank" href="' . $monitoringUrl . '" class="btn btn-sm btn-info">Monitoring</a>
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

        return view('zona.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_zona')) {
            return $response;
        }

        return view('zona.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_zona')) {
            return $response;
        }

        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:zonas,kode',
            'nama' => 'required|string|max:255|unique:zonas,nama',
        ]);

        Zona::create($validated);

        return redirect()->route('zona.index')->with('success', 'Zona berhasil ditambahkan.');
    }

    public function edit(Zona $zona)
    {
        if ($response = $this->checkIzin('akses_master_edit_zona')) {
            return $response;
        }

        return view('zona.edit', compact('zona'));
    }

    public function update(Request $request, Zona $zona)
    {
        if ($response = $this->checkIzin('akses_master_edit_zona')) {
            return $response;
        }

        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:zonas,kode,' . $zona->id,
            'nama' => 'required|string|max:255|unique:zonas,nama,' . $zona->id,
        ]);

        $zona->update($validated);

        return redirect()->route('zona.index')->with('success', 'Zona berhasil diperbarui.');
    }

    public function destroy(Zona $zona)
    {
        if ($response = $this->checkIzin('akses_master_hapus_zona')) {
            return $response;
        }

        $zona->delete();

        return redirect()->route('zona.index')->with('success', 'Zona berhasil dihapus.');
    }
}
