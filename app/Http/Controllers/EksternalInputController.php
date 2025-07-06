<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\InputMonitoringLog;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EksternalInputController extends Controller
{
    public function __invoke($periode, $jam, $titik_pengamatan_id, $parameter_id, $user_id, $value)
    {
        try {
            // Normalisasi format jam
            if (strpos($jam, '-') !== false) {
                $jam = str_replace('-', ':', $jam);
            } elseif (preg_match('/^\d{6}$/', $jam)) {
                $jam = substr($jam, 0, 2) . ':' . substr($jam, 2, 2) . ':' . substr($jam, 4, 2);
            }

            $paramColumn = 'param' . $parameter_id;
            $paramName = Parameter::whereId($parameter_id)->get()->last()->nama;

            // updateOrCreate dan ambil model-nya
            $monitoring = Monitoring::updateOrCreate(
                [
                    'periode' => $periode,
                    'jam' => $jam,
                    'titik_pengamatan_id' => $titik_pengamatan_id,
                ],
                [
                    $paramColumn => $value,
                    'updated_at' => now()
                ]
            );

            // Buat log
            InputMonitoringLog::create([
                'user_id' => $user_id,
                'monitoring_id' => $monitoring->id,
                'keterangan' => "Input dari API eksternal: Set $paramName = $value pada jam $jam"
            ]);

            return response()->json([
                'status' => 'ok',
                'message' => "Data disimpan ke kolom $paramName untuk jam $jam",
            ]);
        } catch (\Exception $e) {
            Log::error("Gagal input eksternal: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan.',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
}
