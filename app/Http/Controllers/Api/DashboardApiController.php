<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TitikPengamatan;
use App\Http\Controllers\Controller;

class DashboardApiController extends Controller
{
    public function index()
    {
        $titik_pengamatans = TitikPengamatan::select(['id', 'nama', 'zona_id'])
            ->with([
                'zona:id,kode,nama',
                'parameter_titik_pengamatans.parameter:id,nama,simbol'
            ])
            ->get();

        return response()->json([
            'titik_pengamatans' => $titik_pengamatans
        ]);
    }
}
