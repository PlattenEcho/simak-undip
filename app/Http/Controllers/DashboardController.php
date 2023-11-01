<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\KHS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function viewDashboardOperator()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Doswal::count();
        return view("operator.dashboard", compact('totalMahasiswa', 'totalDosen'));
    }

    public function viewDashboardMahasiswa()
    {
        $user = auth()->user(); // Mendapatkan pengguna yang login
        $mahasiswa = Mahasiswa::where('iduser', $user->id)->first();
        $ipkTertinggi = KHS::where('nim', $mahasiswa->nim)
            ->orderBy('semester', 'desc')
            ->first();
        return view("mahasiswa.dashboard", compact('mahasiswa', 'ipkTertinggi'));
    }

    public function viewDashboardDoswal()
    {
        return view("doswal.dashboard");
    }
}
