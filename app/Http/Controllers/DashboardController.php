<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'dokter':
                return redirect()->route('dokter.dashboard');
            case 'perawat':
                return redirect()->route('perawat.dashboard');
            case 'kasir':
                return redirect()->route('kasir.dashboard');
            case 'farmasi':
                return redirect()->route('farmasi.dashboard');
            case 'laboratorium':
                return redirect()->route('laboratorium.dashboard');
            case 'radiologi':
                return redirect()->route('radiologi.dashboard');
            default:
                abort(403, 'Role tidak dikenali.');
        }
    }

    public function adminDashboard()
    {
        return view('dashboard.admin');
    }

    public function dokterDashboard()
    {
        $dokter = auth()->user()->dokter;
        return view('dashboard.dokter', compact('dokter'));
    }

    public function perawatDashboard()
    {
        $perawat = auth()->user()->perawat;
        return view('dashboard.perawat', compact('perawat'));
    }

    public function kasirDashboard()
    {
        return view('dashboard.kasir');
    }

    public function farmasiDashboard()
    {
        return view('dashboard.farmasi');
    }

    public function laboratoriumDashboard()
    {
        return view('dashboard.laboratorium');
    }

    public function radiologiDashboard()
    {
        return view('dashboard.radiologi');
    }
}
