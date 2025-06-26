<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\JenisPilihanKualitatif;

class JenisPilihanKualitatifController extends Controller
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
            $data = JenisPilihanKualitatif::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('jenis_pilihan_kualitatif.edit', $row->id);
                    $deleteUrl = route('jenis_pilihan_kualitatif.destroy', $row->id);

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

        return view('jenis_pilihan_kualitatif.index');
    }

    public function create()
    {
        return view('jenis_pilihan_kualitatif.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'kode' => 'required|string|max:50|unique:jenis_pilihan_kualitatifs,kode',
            'keterangan' => 'required|string|max:255|unique:jenis_pilihan_kualitatifs,keterangan',
        ]);

        JenisPilihanKualitatif::create($validated);

        return redirect()->route('jenis_pilihan_kualitatif.index')->with('success', 'Jenis Pilihan Kualitatif berhasil ditambahkan.');
    }

    public function edit(JenisPilihanKualitatif $jenis_pilihan_kualitatif)
    {
        return view('jenis_pilihan_kualitatif.edit', compact('jenis_pilihan_kualitatif'));
    }

    public function update(Request $request, JenisPilihanKualitatif $jenis_pilihan_kualitatif)
    {
        $validated = $request->validate([
            // 'kode' => 'required|string|max:50|unique:jenis_pilihan_kualitatifs,kode,' . $jenis_pilihan_kualitatif->id,
            'keterangan' => 'required|string|max:255|unique:jenis_pilihan_kualitatifs,keterangan,' . $jenis_pilihan_kualitatif->id,
        ]);

        $jenis_pilihan_kualitatif->update($validated);

        return redirect()->route('jenis_pilihan_kualitatif.index')->with('success', 'Jenis Pilihan Kualitatif berhasil diperbarui.');
    }

    public function destroy(JenisPilihanKualitatif $jenis_pilihan_kualitatif)
    {
        $jenis_pilihan_kualitatif->delete();

        return redirect()->route('jenis_pilihan_kualitatif.index')->with('success', 'Jenis Pilihan Kualitatif berhasil dihapus.');
    }
}
