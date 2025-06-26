<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Monitoring;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TitikPengamatan;
use Yajra\DataTables\DataTables;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Eager load hubungan
            $data       = Monitoring::with('titik_pengamatan');
            $parameters = Parameter::with('satuan')->get();

            return DataTables::of($data)
                ->addIndexColumn()

                // Nama titik pengamatan
                ->addColumn('titik_pengamatan_nama', fn($row) =>
                    $row->titik_pengamatan->nama ?? '-'
                )

                // Daftar parameter
                ->addColumn('parameter', function ($row) use ($parameters) {
                    $listItems = '';
                    foreach ($parameters as $parameter) {
                        $field = 'param' . $parameter->id;
                        $value = $row->{$field};

                        if (! is_null($value)) {
                            // Jika kualitatif, jangan tampilkan satuan
                            if ($parameter->jenis === 'kualitatif') {
                                $listItems .= '<li>'
                                    . e($parameter->simbol) . ': '
                                    . e($value)
                                    . '</li>';
                            } else {
                                // kuantitatif: tampilkan satuan
                                $satuan = $parameter->satuan->simbol ?? '';
                                $listItems .= '<li>'
                                    . e($parameter->simbol) . ': '
                                    . e($value) . ' '
                                    . e($satuan)
                                    . '</li>';
                            }
                        }
                    }
                    if ($listItems === '') {
                        return '-';
                    }
                    return '<ul class="mb-0 ps-3">' . $listItems . '</ul>';
                })

                // Aksi edit/hapus
                ->addColumn('aksi', function ($row) {
                    $editUrl   = route('monitoring.edit', $row->id);
                    $deleteUrl = route('monitoring.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })

                ->rawColumns(['parameter', 'aksi'])
                ->make(true);
        }

        return view('monitoring.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('monitoring.create', [
            'titik_pengamatans' => TitikPengamatan::orderBy('urutan', 'asc')->get(),
            'parameters' => Parameter::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1) Validasi dasar
        $request->validate([
            'periode'               => 'required|date',
            'jam'                   => 'required|date_format:H:i',
            'titik_pengamatan_id'   => 'required|exists:titik_pengamatans,id',
        ]);

        // 2) Ambil seluruh parameter yang akan diproses
        //    (misal, kamu sudah punya koleksi $parameters yg dipassing ke view)
        $allParamIds = collect($request->all())
            ->keys()
            ->filter(fn($k) => Str::startsWith($k, 'param'))
            ->map(fn($k) => (int) Str::after($k, 'param'))
            ->all();

        $parameters = Parameter::whereIn('id', $allParamIds)
            ->pluck('jenis', 'id'); // ['1'=>'kuantitatif', '2'=>'kualitatif', ...]

        // 3) Kondisi unik untuk updateOrCreate
        $conditions = [
            'periode'             => $request->periode,
            'jam'                 => $request->jam,
            'titik_pengamatan_id' => $request->titik_pengamatan_id,
        ];

        // 4) Bangun data untuk disimpan
        $dataToSave = [];
        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'param')) {
                $paramId = (int) Str::after($key, 'param');
                $jenis   = $parameters->get($paramId);

                if ($jenis === 'kuantitatif') {
                    // cast angka
                    $dataToSave[$key] = $value !== null && $value !== ''
                        ? floatval($value)
                        : null;
                } else {
                    // simpan string (boleh kosong)
                    $dataToSave[$key] = $value !== null && $value !== ''
                        ? $value
                        : null;
                }
            }
        }

        // 5) Create or update
        Monitoring::updateOrCreate($conditions, $dataToSave);

        return redirect()
            ->route('monitoring.index')
            ->with('success', 'Data monitoring berhasil disimpan atau diperbarui.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Monitoring $monitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monitoring $monitoring)
    {
        return view('monitoring.edit', [
            'monitoring' => $monitoring,
            'titik_pengamatans' => TitikPengamatan::orderBy('urutan', 'asc')->get(),
            'parameters' => Parameter::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monitoring $monitoring)
    {
        // 1) Normalize jam (ambil HH:MM)
        $request->merge([
            'jam' => substr($request->jam, 0, 5),
        ]);

        // 2) Validasi dasar
        $request->validate([
            'periode'             => 'required|date',
            'jam'                 => 'required|date_format:H:i',
            'titik_pengamatan_id' => 'required|exists:titik_pengamatans,id',
        ]);

        // 3) Kumpulkan semua parameter IDs dari input
        $paramIds = collect($request->all())
            ->keys()
            ->filter(fn($k) => Str::startsWith($k, 'param'))
            ->map(fn($k) => (int) Str::after($k, 'param'))
            ->all();

        // 4) Ambil jenis tiap parameter: ['1'=>'kuantitatif', ...]
        $jenisMap = Parameter::whereIn('id', $paramIds)
            ->pluck('jenis', 'id');

        // 5) Siapkan data utama
        $data = [
            'periode'             => $request->periode,
            'jam'                 => $request->jam,
            'titik_pengamatan_id' => $request->titik_pengamatan_id,
        ];

        // 6) Loop semua field "param{ID}"
        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'param')) {
                $id    = (int) Str::after($key, 'param');
                $jenis = $jenisMap->get($id);

                if ($jenis === 'kuantitatif') {
                    // cast ke float
                    $data[$key] = $value !== null && $value !== ''
                        ? floatval($value)
                        : null;
                } else {
                    // simpan string
                    $data[$key] = $value !== null && $value !== ''
                        ? $value
                        : null;
                }
            }
        }

        // 7) Update record
        $monitoring->update($data);

        return redirect()
            ->route('monitoring.index')
            ->with('success', 'Monitoring berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        $monitoring->delete();

        return redirect()->route('monitoring.index')->with('success', 'Monitoring berhasil dihapus.');
    }
}
