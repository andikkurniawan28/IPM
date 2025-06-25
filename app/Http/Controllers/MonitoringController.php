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
            $data = Monitoring::with(['titik_pengamatan']); // eager load relasi
            $parameters = Parameter::with('satuan')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('titik_pengamatan_nama', function ($row) {
                    return $row->titik_pengamatan->nama ?? '-';
                })
                ->addColumn('parameter', function ($row) use ($parameters) {
                    $listItems = '';

                    foreach ($parameters as $parameter) {
                        $field = 'param' . $parameter->id;
                        $value = $row->{$field};

                        if (!is_null($value)) {
                            $listItems .= '<li>' . $parameter->nama . ' / ' . $parameter->simbol . ': ' . $value . ' ' . $parameter->satuan->simbol . '</li>';
                        }
                    }

                    return $listItems ? '<ul class="mb-0 ps-3">' . $listItems . '</ul>' : '-';
                })
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('monitoring.edit', $row->id);
                    $deleteUrl = route('monitoring.destroy', $row->id);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                ';
                })
                ->rawColumns(['aksi', 'parameter'])
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
            'titik_pengamatans' => TitikPengamatan::all(),
            'parameters' => Parameter::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'periode' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'titik_pengamatan_id' => 'required|exists:titik_pengamatans,id',
        ]);

        // Key pencocokan
        $conditions = [
            'periode' => $request->periode,
            'jam' => $request->jam,
            'titik_pengamatan_id' => $request->titik_pengamatan_id,
        ];

        // Data yang akan diupdate atau dibuat
        $dataToSave = [];

        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'param')) {
                $dataToSave[$key] = $value !== null && $value !== '' ? floatval($value) : null;
            }
        }

        // Gabungkan condition + data
        Monitoring::updateOrCreate($conditions, $dataToSave);

        return redirect()->route('monitoring.index')->with('success', 'Data monitoring berhasil disimpan atau diperbarui.');
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
            'titik_pengamatans' => TitikPengamatan::all(),
            'parameters' => Parameter::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monitoring $monitoring)
    {
        $request->merge([
            'jam' => substr($request->jam, 0, 5),
        ]);

        // Validasi dasar
        $request->validate([
            'periode' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'titik_pengamatan_id' => 'required|exists:titik_pengamatans,id',
        ]);

        // Siapkan data utama
        $data = [
            'periode' => $request->periode,
            'jam' => $request->jam,
            'titik_pengamatan_id' => $request->titik_pengamatan_id,
        ];

        // Loop semua input "param{id}" dan ambil nilainya
        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'param')) {
                $data[$key] = $value !== null && $value !== '' ? floatval($value) : null;
            }
        }

        // Update monitoring
        $monitoring->update($data);

        return redirect()->route('monitoring.index')->with('success', 'Monitoring berhasil diperbarui.');
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
