<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\KategoriParameter;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Parameter::with(['kategori_parameter', 'satuan']); // eager load relasi

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
                ->rawColumns(['aksi', 'satuan_nama'])
                ->make(true);
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'simbol' => 'required|string|max:50',
            'kategori_parameter_id' => 'required|exists:kategori_parameters,id',
            'satuan_id' => 'required|exists:satuans,id',
            'keterangan' => 'nullable|string',
        ]);

        // return $validated;

        Parameter::create($validated);

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil ditambahkan.');
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
        return view('parameter.edit', [
            'parameter' => $parameter,
            'kategori_parameters' => KategoriParameter::all(),
            'satuans' => Satuan::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parameter $parameter)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'simbol' => 'required|string|max:50',
            'kategori_parameter_id' => 'required|exists:kategori_parameters,id',
            'satuan_id' => 'required|exists:satuans,id',
            'keterangan' => 'nullable|string',
        ]);

        $parameter->update($validated);

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil diperbarui.');
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
