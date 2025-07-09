<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\TitikPengamatan;
use App\Models\KategoriParameter;

class MonitoringPerKategoriController extends Controller
{
    public function index($kategori_parameter_id)
    {
        if ($response = $this->checkIzin("akses_monitoring_kategori{$kategori_parameter_id}")) {
            return $response;
        }

        $kategori_parameter = KategoriParameter::whereId($kategori_parameter_id)->get()->last();
        return view('monitoring_per_kategori.index', compact('kategori_parameter', 'kategori_parameter_id'));
    }

    public function data_old($kategori_parameter_id)
    {
        $titik_pengamatans = TitikPengamatan::with([
            'zona:id,kode,nama',
            'parameter_titik_pengamatans.parameter' => function ($query) use ($kategori_parameter_id) {
                $query->where('kategori_parameter_id', $kategori_parameter_id)->with('satuan:id,simbol');
            }
        ])
            ->orderBy('urutan', 'asc')
            ->get()
            ->map(function ($titik) {
                $parameterList = $titik->parameter_titik_pengamatans
                    ->filter(fn($ptp) => $ptp->parameter) // hanya yang lolos filter kategori
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
            })
            ->filter(fn($titik) => count($titik['parameters']) > 0) // hanya titik yang punya parameter di kategori ini
            ->values();

        return response()->json([
            'titik_pengamatans' => $titik_pengamatans
        ]);
    }

    public function data($kategori_parameter_id)
    {
        $titik_pengamatans = TitikPengamatan::with([
            'zona:id,kode,nama',
            'parameter_titik_pengamatans.parameter' => function ($query) use ($kategori_parameter_id) {
                $query->where('kategori_parameter_id', $kategori_parameter_id)
                    ->with('satuan:id,simbol');
            }
        ])
        ->orderBy('urutan', 'asc')
        ->get()
        ->map(function ($titik) {
            // Ambil parameter dari titik ini (yang sudah difilter kategori sebelumnya)
            $parameterList = $titik->parameter_titik_pengamatans
                ->filter(fn($ptp) => $ptp->parameter)
                ->map(function ($ptp) {
                    return [
                        'id' => $ptp->parameter->id,
                        'simbol' => $ptp->parameter->simbol,
                        'satuan' => $ptp->parameter->satuan->simbol ?? '',
                        'jenis' => $ptp->parameter->jenis,
                        'metode_agregasi' => $ptp->parameter->metode_agregasi ?? null
                    ];
                })
                ->values();

            // Ambil data monitoring
            $monitorings = Monitoring::where('titik_pengamatan_id', $titik->id)
                ->where('periode', session('periode'))
                ->orderByDesc('periode')
                ->orderByDesc('jam')
                ->get();

            // Bentuk monitoring per baris
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

            // Buat hasil agregasi
            $aggregated = [];
            foreach ($parameterList as $param) {
                $field = 'param' . $param['id'];

                if ($param['jenis'] === 'kuantitatif') {
                    $values = $monitorings->pluck($field)->filter(fn($val) => is_numeric($val));

                    $aggregated[$field] = match (strtolower($param['metode_agregasi'])) {
                        'sum' => $values->sum(),
                        'avg', 'average' => $values->avg(),
                        'count' => $values->count(),
                        default => null,
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
                'lebar' => $titik->lebar,
                'parameters' => $parameterList,
                'monitorings' => $monitoringData,
                'agregasi' => $aggregated
            ];
        })
        ->filter(fn($titik) => count($titik['parameters']) > 0)
        ->values();

        return response()->json([
            'titik_pengamatans' => $titik_pengamatans
        ]);
    }

}
