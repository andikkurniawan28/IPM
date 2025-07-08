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
        if ($response = $this->checkIzin("akses_monitoring_zona{$zona_id}")) {
            return $response;
        }

        $zona = Zona::select('id', 'nama', 'kode')->findOrFail($zona_id);
        return view('monitoring_per_zona.index', compact('zona', 'zona_id'));
    }

    public function data_old($zona_id)
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
                        'satuan' => $ptp->parameter->satuan->simbol ?? '',
                        'jenis' => $ptp->parameter->jenis,
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
                'kode' => $titik->kode,
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
                ->filter(fn($ptp) => $ptp->parameter)
                ->map(function ($ptp) {
                    return [
                        'id' => $ptp->parameter->id,
                        'simbol' => $ptp->parameter->simbol,
                        'satuan' => $ptp->parameter->satuan->simbol ?? '',
                        'jenis' => $ptp->parameter->jenis,
                        'metode_agregasi' => strtolower($ptp->parameter->metode_agregasi ?? '')
                    ];
                })
                ->values();

            // Ambil monitoring
            $monitorings = Monitoring::where('titik_pengamatan_id', $titik->id)
                ->where('periode', session('periode'))
                ->orderByDesc('periode')
                ->orderByDesc('jam')
                ->get();

            // Ubah monitoring jadi format array
            $monitoringData = $monitorings->map(function ($monitoring) use ($parameterList) {
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

            // Agregasi
            $aggregated = [];
            foreach ($parameterList as $param) {
                $field = 'param' . $param['id'];

                if ($param['jenis'] === 'kuantitatif') {
                    $values = $monitorings->pluck($field)->filter(fn($val) => is_numeric($val));

                    $aggregated[$field] = match ($param['metode_agregasi']) {
                        'sum'     => $values->sum(),
                        'avg',
                        'average' => $values->avg(),
                        'count'   => $values->count(),
                        'min'     => $values->min(),
                        'max'     => $values->max(),
                        default   => null,
                    };
                } else {
                    $aggregated[$field] = null;
                }
            }

            return [
                'id' => $titik->id,
                'kode' => $titik->kode,
                'nama' => $titik->nama,
                'zona' => $titik->zona,
                'parameters' => $parameterList,
                'monitorings' => $monitoringData,
                'agregasi' => $aggregated
            ];
        });

        return response()->json([
            'titik_pengamatans' => $titik_pengamatans
        ]);
    }

}
