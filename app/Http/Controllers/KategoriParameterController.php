<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\KategoriParameter;
use Illuminate\Support\Facades\Auth;

class KategoriParameterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->role || !Auth::user()->role->izin_akses_master) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin akses.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriParameter::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('kategori_parameter.edit', $row->id);
                    $deleteUrl = route('kategori_parameter.destroy', $row->id);

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

        return view('kategori_parameter.index');
    }

    public function create()
    {
        return view('kategori_parameter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'kode' => 'required|string|max:50|unique:kategori_parameters,kode',
            'nama' => 'required|string|max:255|unique:kategori_parameters,nama',
        ]);

        KategoriParameter::create($validated);

        return redirect()->route('kategori_parameter.index')->with('success', 'Kategori Parameter berhasil ditambahkan.');
    }

    public function edit(KategoriParameter $kategori_parameter)
    {
        return view('kategori_parameter.edit', compact('kategori_parameter'));
    }

    public function update(Request $request, KategoriParameter $kategori_parameter)
    {
        $validated = $request->validate([
            // 'kode' => 'required|string|max:50|unique:kategori_parameters,kode,' . $kategori_parameter->id,
            'nama' => 'required|string|max:255|unique:kategori_parameters,nama,' . $kategori_parameter->id,
        ]);

        $kategori_parameter->update($validated);

        return redirect()->route('kategori_parameter.index')->with('success', 'Kategori Parameter berhasil diperbarui.');
    }

    public function destroy(KategoriParameter $kategori_parameter)
    {
        $kategori_parameter->delete();

        return redirect()->route('kategori_parameter.index')->with('success', 'Kategori Parameter berhasil dihapus.');
    }
}
