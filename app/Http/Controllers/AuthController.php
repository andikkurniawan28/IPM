<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['aktif'] = 1;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Tambahkan session 'periode' dengan tanggal hari ini
            session(['periode' => date('Y-m-d')]);

            return redirect()->intended();
        }

        return back()->with('error', 'Invalid credentials or your account is inactive.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function changeSessionPeriode(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        session(['periode' => $request->tanggal]);

        return back(); // atau redirect()->route('dashboard'); jika ingin redirect ke route tertentu
    }
}
