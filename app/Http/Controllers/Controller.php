<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function checkIzin($izinKey)
    {
        $user = Auth::user();

        if (!$user || !$user->role || !$user->role->{$izinKey}) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin akses.');
        }

        return null; // eksplisitkan bahwa ini boleh lanjut
    }
}
