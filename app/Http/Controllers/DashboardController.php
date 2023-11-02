<?php

namespace App\Http\Controllers;

use App\Charts\CountMahasiswaChart;
use App\Models\Doswal;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function viewDashboardOperator(CountMahasiswaChart $chart)
    {
        $chart = $chart->build();
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Doswal::count();
        $countMahasiswa = Mahasiswa::select('angkatan', DB::raw('count(*) as total_mahasiswa'))
            ->groupBy('angkatan')
            ->get();


        return view("operator.dashboard", compact('totalMahasiswa', 'totalDosen', 'countMahasiswa', 'chart'));
    }

    public function viewDashboardMahasiswa()
    {
        $user = auth()->user(); // Mendapatkan pengguna yang login
        $mahasiswa = Mahasiswa::where('iduser', $user->id)->first();
        $ipkTertinggi = KHS::where('nim', $mahasiswa->nim)
            ->orderBy('semester', 'desc')
            ->first();
        // $semester = IRS::where('nim', $mahasiswa->nim)
        //     ->

        $semester = IRS::where('nim', $mahasiswa->nim)
            ->where('status', 'Approved')
            ->pluck('semester')
            ->toArray();
        
        if (empty($semester)) {
            $semesterAktif = 1;
        } else {
            $semesterAktif = max($semester);
        }

        return view("mahasiswa.dashboard", compact('mahasiswa', 'ipkTertinggi', 'semesterAktif'));
    }

    public function viewDashboardDoswal()
    {
        return view("doswal.dashboard");
    }
}
