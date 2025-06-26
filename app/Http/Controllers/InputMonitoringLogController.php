<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\InputMonitoringLog;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class InputMonitoringLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->role || !Auth::user()->role->izin_akses_input) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin akses.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = InputMonitoringLog::with(['user']); // eager load relasi

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_nama', function ($row) {
                    return $row->user->name ?? '-';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d-m-Y H:i') : '-';
                })
                ->rawColumns(['user_nama', 'created_at'])
                ->make(true);
        }

        return view('input_monitoring_log.index');
    }
}
