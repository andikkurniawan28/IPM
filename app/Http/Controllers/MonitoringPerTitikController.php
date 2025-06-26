<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\TitikPengamatan;
use App\Models\ParameterTitikPengamatan;
use DataTables;

class MonitoringPerTitikController extends Controller
{
    public function index($titik_pengamatan_id)
    {
        $titik = TitikPengamatan::with('zona:id,nama,kode')->findOrFail($titik_pengamatan_id);
        $parameter_list = ParameterTitikPengamatan::with('parameter')
            ->where('titik_pengamatan_id', $titik_pengamatan_id)
            ->get();
        return view('monitoring_per_titik.index', compact('titik', 'titik_pengamatan_id', 'parameter_list'));
    }

    public function dataX($titik_pengamatan_id)
    {
        // Ambil parameter ID yang digunakan di titik ini
        $parameter_ids = ParameterTitikPengamatan::where('titik_pengamatan_id', $titik_pengamatan_id)
            ->pluck('parameter_id');

        // Ambil informasi titik dan zona
        $titik = TitikPengamatan::with('zona:id,nama,kode')->findOrFail($titik_pengamatan_id);

        // Ambil monitoring dan hanya tampilkan paramX yang relevan
        $monitorings = Monitoring::where('titik_pengamatan_id', $titik_pengamatan_id)
            ->where('periode', session('periode'))
            ->orderByDesc('periode')
            ->orderByDesc('jam')
            ->get()
            ->map(function ($m) use ($parameter_ids) {
                $data = [
                    'periode' => $m->periode,
                    'jam' => $m->jam,
                ];

                foreach ($parameter_ids as $param_id) {
                    $key = 'param' . $param_id;
                    $data[$key] = $m->{$key};
                }

                return $data;
            });

        return response()->json([
            'titik_pengamatan' => [
                'id' => $titik->id,
                'nama' => $titik->nama,
                'zona' => $titik->zona,
                'monitorings' => $monitorings->values()
            ]
        ]);
    }

    public function data($titik_pengamatan_id)
    {
        $parameter_ids = ParameterTitikPengamatan::where('titik_pengamatan_id', $titik_pengamatan_id)
            ->pluck('parameter_id')
            ->toArray();

        // Kolom default yang pasti dibutuhkan
        $columns = ['id', 'periode', 'jam'];

        // Tambahkan hanya kolom paramX yang sesuai parameter_id
        foreach ($parameter_ids as $param_id) {
            $columns[] = 'param' . $param_id;
        }

        return DataTables::of(
            Monitoring::select($columns) // ← batasi kolom di sini
                ->where('titik_pengamatan_id', $titik_pengamatan_id)
                // ->where('periode', session('periode'))
                ->orderByDesc('periode')
                ->orderByDesc('jam')
        )
            ->addColumn('parameter_values', function ($m) use ($parameter_ids) {
                $values = '';
                foreach ($parameter_ids as $param_id) {
                    $key = 'param' . $param_id;
                    $val = $m->{$key};
                    $values .= "<div><strong>Param{$param_id}:</strong> " . ($val ?? '-') . "</div>";
                }
                return $values;
            })
            ->rawColumns(['parameter_values'])
            ->make(true);
    }
}
