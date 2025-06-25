<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringAllController extends Controller
{
    public function index(){
        return view('monitoring_all');
    }
}
