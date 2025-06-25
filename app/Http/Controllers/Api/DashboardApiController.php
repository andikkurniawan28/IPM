<?php

namespace App\Http\Controllers\Api;

use App\Models\Parameter;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\TitikPengamatan;
use App\Http\Controllers\Controller;

class DashboardApiController extends Controller
{
    public function index()
    {
        $titik_pengamatans = TitikPengamatan::with([
            'zona:id,kode,nama',
            'parameter_titik_pengamatans.parameter.satuan'
        ])->get()->map(function ($titik) {
            $parameterList = $titik->parameter_titik_pengamatans->map(function ($ptp) {
                return [
                    'id' => $ptp->parameter->id,
                    'simbol' => $ptp->parameter->simbol,
                    'satuan' => $ptp->parameter->satuan->simbol ?? ''
                ];
            });

            $monitorings = Monitoring::where('titik_pengamatan_id', $titik->id)
                ->orderByDesc('periode')
                ->orderByDesc('jam')
                ->limit(10) // Untuk sementara
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
                'parameters' => $parameterList,
                'monitorings' => $monitorings
            ];
        });

        return response()->json([
            'titik_pengamatans' => $titik_pengamatans
        ]);
    }
}
