<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
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
            $data = Role::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('role.edit', $row->id);
                    $deleteUrl = route('role.destroy', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->addColumn('izin', function ($row) {
                    $input = $row->izin_akses_input ? '✅ Input' : '❌ Input';
                    $laporan = $row->izin_akses_laporan ? '✅ Laporan' : '❌ Laporan';
                    $master = $row->izin_akses_master ? '✅ Master' : '❌ Master';

                    return implode('<br>', [$input, $master]);
                })
                ->rawColumns(['aksi', 'izin'])
                ->make(true);
        }

        return view('role.index');
    }

    public function create()
    {
        return view('role.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:roles,nama',
        ]);

        $validated['izin_akses_input'] = $request->has('izin_akses_input');
        // $validated['izin_akses_laporan'] = $request->has('izin_akses_laporan');
        $validated['izin_akses_master'] = $request->has('izin_akses_master');

        Role::create($validated);

        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:roles,nama,' . $role->id,
        ]);

        $validated['izin_akses_input'] = $request->has('izin_akses_input');
        // $validated['izin_akses_laporan'] = $request->has('izin_akses_laporan');
        $validated['izin_akses_master'] = $request->has('izin_akses_master');

        $role->update($validated);

        return redirect()->route('role.index')->with('success', 'Kategori Parameter berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Kategori Parameter berhasil dihapus.');
    }
}
