<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\TitikPengamatan;
use App\Models\Zona;
use Illuminate\Http\Request;

class MonitoringPerZonaController extends Controller
{
    public function index($zona_id)
    {
        $zona = Zona::select('id', 'nama', 'kode')->findOrFail($zona_id);
        return view('monitoring_per_zona.index', compact('zona', 'zona_id'));
    }

    public function data($zona_id)
    {
        $titik_pengamatans = TitikPengamatan::with([
            'zona:id,kode,nama',
            'parameter_titik_pengamatans.parameter.satuan'
        ])
        ->where('zona_id', $zona_id)
        ->orderBy('urutan', 'asc')
        ->get()
        ->map(function ($titik) {
            $parameterList = $titik->parameter_titik_pengamatans
                ->filter(fn($ptp) => $ptp->parameter) // valid parameter saja
                ->map(function ($ptp) {
                    return [
                        'id' => $ptp->parameter->id,
                        'simbol' => $ptp->parameter->simbol,
                        'satuan' => $ptp->parameter->satuan->simbol ?? ''
                    ];
                });

            $monitorings = Monitoring::where('titik_pengamatan_id', $titik->id)
                ->where('periode', session('periode'))
                ->orderByDesc('periode')
                ->orderByDesc('jam')
                ->get()
                ->map(function ($monitoring) use ($parameterList) {
                    $data = [
                        'periode' => $monitoring->periode,
                        'jam' => $monitoring->jam,
                    ];

                    foreach ($parameterList as $param) {
                        $field = 'param' . $param['id'];
                        $data[$field] = $monitoring->{$field};
                    }

                    return $data;
                });

            return [
                'id' => $titik->id,
                'nama' => $titik->nama,
                'zona' => $titik->zona,
                'parameters' => $parameterList->values(),
                'monitorings' => $monitorings
            ];
        });

        return response()->json([
            'titik_pengamatans' => $titik_pengamatans
        ]);
    }
}
