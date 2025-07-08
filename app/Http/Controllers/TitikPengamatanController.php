<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Models\TitikPengamatan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\ParameterTitikPengamatan;

class TitikPengamatanController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_titik_pengamatan')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = TitikPengamatan::with(['zona', 'parameter_titik_pengamatans.parameter'])->orderBy('titik_pengamatans.urutan', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('zona_nama', function ($row) {
                    return $row->zona->nama ?? '-';
                })
                ->addColumn('daftar_parameter', function ($row) {
                    if ($row->parameter_titik_pengamatans->isEmpty()) {
                        return '<em class="text-muted">Belum ada parameter</em>';
                    }

                    $list = '<ul class="mb-0">';
                    foreach ($row->parameter_titik_pengamatans as $ptp) {
                        $parameter = $ptp->parameter;
                        $satuan = $parameter?->satuan?->simbol ?? '';
                        $list .= '<li>' . ($parameter->simbol ?? '-') . ' | ' . ($parameter->nama ?? '-') . ($satuan ? " <sub>({$satuan})</sub>" : '') . '</li>';
                    }
                    $list .= '</ul>';

                    return $list;
                })
                ->addColumn('aksi', function ($row) {
                    $monitoringUrl = route('monitoring_per_titik.index', $row->id);
                    $editUrl = route('titik_pengamatan.edit', $row->id);
                    $deleteUrl = route('titik_pengamatan.destroy', $row->id);

                    return '
                        <a target="_blank" href="' . $monitoringUrl . '" class="btn btn-sm btn-info">Monitoring</a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi', 'daftar_parameter'])
                ->make(true);
        }

        return view('titik_pengamatan.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_titik_pengamatan')) {
            return $response;
        }

        return view('titik_pengamatan.create', [
            'zonas' => Zona::all(),
            'parameters' => Parameter::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_titik_pengamatan')) {
            return $response;
        }

        $request->request->add(['urutan' => TitikPengamatan::max('urutan') + 1]);
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1',
            'zona_id' => 'required|exists:zonas,id',
            'kode' => 'required|string|max:50|unique:titik_pengamatans,kode',
            'nama' => 'required|string|max:255|unique:titik_pengamatans,nama',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan Titik Pengamatan
        $titik = TitikPengamatan::create([
            'urutan' => $validated['urutan'],
            'zona_id' => $validated['zona_id'],
            'kode' => $validated['kode'],
            'nama' => $validated['nama'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('titik_pengamatan.index')->with('success', 'Titik Pengamatan berhasil ditambahkan.');
    }

    public function edit(TitikPengamatan $titik_pengamatan)
    {
        if ($response = $this->checkIzin('akses_master_edit_titik_pengamatan')) {
            return $response;
        }

        return view('titik_pengamatan.edit', [
            'titik_pengamatan' => $titik_pengamatan,
            'zonas' => Zona::all(),
            'parameters' => Parameter::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->checkIzin('akses_master_edit_titik_pengamatan')) {
            return $response;
        }

        $validated = $request->validate([
            'urutan' => 'required|unique:titik_pengamatans,urutan,' . $id,
            'zona_id' => 'required|exists:zonas,id',
            'kode' => 'required|string|max:50|unique:titik_pengamatans,kode,' . $id,
            'nama' => 'required|string|max:255|unique:titik_pengamatans,nama,' . $id,
            'keterangan' => 'nullable|string',
            'parameter_id' => 'array',
            'parameter_id.*' => 'exists:parameters,id',
        ]);

        $titik = TitikPengamatan::findOrFail($id);

        $titik->update([
            'urutan' => $validated['urutan'],
            'zona_id' => $validated['zona_id'],
            'kode' => $validated['kode'],
            'nama' => $validated['nama'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        // Reset semua parameter_titik_pengamatan sebelumnya
        $titik->parameter_titik_pengamatans()->delete();

        // Tambahkan ulang dari checkbox
        if (!empty($validated['parameter_id'])) {
            foreach ($validated['parameter_id'] as $pid) {
                ParameterTitikPengamatan::create([
                    'titik_pengamatan_id' => $titik->id,
                    'parameter_id' => $pid,
                ]);
            }
        }

        return redirect()->route('titik_pengamatan.index')
            ->with('success', 'Titik Pengamatan berhasil diperbarui.');
    }

    public function destroy(TitikPengamatan $titik_pengamatan)
    {
        if ($response = $this->checkIzin('akses_master_hapus_titik_pengamatan')) {
            return $response;
        }

        $titik_pengamatan->delete();

        return redirect()->route('titik_pengamatan.index')->with('success', 'Titik Pengamatan berhasil dihapus.');
    }
}
