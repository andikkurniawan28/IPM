<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\KategoriParameter;
use App\Models\PilihanKualitatif;
use App\Models\JenisPilihanKualitatif;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Parameter::with(['kategori_parameter', 'satuan', 'pilihan_kualitatifs.jenis_pilihan_kualitatif']); // eager load relasi

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori_parameter_nama', function ($row) {
                    return $row->kategori_parameter->nama ?? '-';
                })
                ->addColumn('satuan_nama', function ($row) {
                    return $row->satuan
                        ? $row->satuan->nama . '<sub>(' . $row->satuan->simbol . ')</sub>'
                        : '-';
                })
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('parameter.edit', $row->id);
                    $deleteUrl = route('parameter.destroy', $row->id);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                ';
                })
                ->addColumn('pilihan', function($row) {
                    if ($row->jenis === 'kualitatif' && $row->pilihan_kualitatifs->isNotEmpty()) {
                        $html = '<ul class="mb-0 ps-3">';
                        foreach ($row->pilihan_kualitatifs as $pil) {
                            $keterangan = $pil->jenis_pilihan_kualitatif->keterangan ?? $pil->jenis_pilihan_kualitatif_id;
                            $html .= '<li>' . e($keterangan) . '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    }
                    return '-';
                })
                ->rawColumns(['aksi', 'satuan_nama', 'pilihan'])
                ->make(true);

        // return $data;
        }

        return view('parameter.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parameter.create', [
            'kategori_parameters' => KategoriParameter::all(),
            'satuans' => Satuan::all(),
            'jenis_pilihan_kualitatifs' => JenisPilihanKualitatif::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 0) Beri default jika tidak dikirim
        $request->merge([
            'jenis' => $request->input('jenis', 'kuantitatif')
        ]);

        // 1) Validasi
        $data = $request->validate([
            'nama'                  => 'required|string|unique:parameters,nama',
            'simbol'                => 'required|string|unique:parameters,simbol',
            'kategori_parameter_id' => 'required|exists:kategori_parameters,id',
            'jenis'                 => 'required|in:kuantitatif,kualitatif',
            'satuan_id'             => 'nullable|required_if:jenis,kuantitatif|exists:satuans,id',
            'metode_agregasi'       => 'nullable|required_if:jenis,kuantitatif|in:sum,avg,count',
            'pilihan_kualitatif'    => 'nullable|array',
            'pilihan_kualitatif.*'  => 'exists:jenis_pilihan_kualitatifs,id',
            'keterangan'            => 'nullable|string',
        ]);

        // 2) Buat Parameter
        $param = Parameter::create([
            'nama'                  => $data['nama'],
            'simbol'                => $data['simbol'],
            'kategori_parameter_id' => $data['kategori_parameter_id'],
            'jenis'                 => $data['jenis'],
            'satuan_id'             => $data['jenis'] === 'kuantitatif' ? $data['satuan_id'] : null,
            'metode_agregasi'       => $data['jenis'] === 'kuantitatif' ? $data['metode_agregasi'] : null,
            'keterangan'            => $data['keterangan'] ?? null,
        ]);

        // 4) Jika KUALITATIF → Simpan pilihan di pivot
        if ($param->jenis === 'kualitatif' && !empty($data['pilihan_kualitatif'])) {
            foreach ($data['pilihan_kualitatif'] as $jenisPilId) {
                PilihanKualitatif::create([
                    'parameter_id'               => $param->id,
                    'jenis_pilihan_kualitatif_id' => $jenisPilId,
                ]);
            }
        }

        return redirect()
            ->route('parameter.index')
            ->with('success', 'Parameter berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Parameter $parameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parameter $parameter)
    {
        $selectedPilihan = $parameter
            ->pilihan_kualitatifs
            ->pluck('jenis_pilihan_kualitatif_id')
            ->toArray();
        return view('parameter.edit', [
            'parameter' => $parameter,
            'kategori_parameters' => KategoriParameter::all(),
            'satuans' => Satuan::all(),
            'jenis_pilihan_kualitatifs' => JenisPilihanKualitatif::all(),
            'selectedPilihan' => $selectedPilihan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parameter $parameter)
    {
        // 1) Validasi input, pastikan `jenis` wajib
        $data = $request->validate([
            'nama'                  => 'required|string|max:255|unique:parameters,nama,' . $parameter->id,
            'simbol'                => 'required|string|max:50|unique:parameters,simbol,' . $parameter->id,
            'kategori_parameter_id' => 'required|exists:kategori_parameters,id',
            'jenis'                 => 'required|in:kuantitatif,kualitatif',
            'satuan_id'             => 'nullable|required_if:jenis,kuantitatif|exists:satuans,id',
            'metode_agregasi'       => 'nullable|required_if:jenis,kuantitatif|in:sum,avg,count',
            'keterangan'            => 'nullable|string',
            'pilihan_kualitatif'    => 'nullable|array',
            'pilihan_kualitatif.*'  => 'exists:jenis_pilihan_kualitatifs,id',
        ]);

        // 2) Update main record
        $parameter->update([
            'nama'                  => $data['nama'],
            'simbol'                => $data['simbol'],
            'kategori_parameter_id' => $data['kategori_parameter_id'],
            'jenis'                 => $data['jenis'],
            'satuan_id'             => $data['jenis'] === 'kuantitatif' ? $data['satuan_id'] : null,
            'metode_agregasi'       => $data['jenis'] === 'kuantitatif' ? $data['metode_agregasi'] : null,
            'keterangan'            => $data['keterangan'] ?? null,
        ]);

        // 3) Reset PilihanKualitatif pivot
        PilihanKualitatif::where('parameter_id', $parameter->id)->delete();

        // 4) Re-insert pilihan hanya jika kualitatif
        if ($data['jenis'] === 'kualitatif' && !empty($data['pilihan_kualitatif'])) {
            foreach ($data['pilihan_kualitatif'] as $idPil) {
                PilihanKualitatif::create([
                    'parameter_id'                => $parameter->id,
                    'jenis_pilihan_kualitatif_id' => $idPil,
                ]);
            }
        }

        return redirect()
            ->route('parameter.index')
            ->with('success', 'Parameter berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parameter $parameter)
    {
        $parameter->delete();

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil dihapus.');
    }
}
