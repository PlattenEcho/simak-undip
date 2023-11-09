<?php

namespace App\Http\Controllers;

use App\Charts\CountMahasiswaChart;
use App\Charts\CountMahasiswaPkl;
use App\Charts\CountMahasiswaSkripsi;
use App\Models\Doswal;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\Operator;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function viewDashboardOperator(CountMahasiswaChart $chart)
    {
        $user = auth()->user(); // Mendapatkan pengguna yang login
        $operator = Operator::where('iduser', $user->id)->first();
        $chart = $chart->build();
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Doswal::count();
        $countMahasiswa = Mahasiswa::select('angkatan', DB::raw('count(*) as total_mahasiswa'))
            ->groupBy('angkatan')
            ->get();


        return view("operator.dashboard", compact('operator', 'totalMahasiswa', 'totalDosen', 'countMahasiswa', 'chart'));
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

    public function viewDashboardDoswal(CountMahasiswaPkl $chartPKL, CountMahasiswaSkripsi $chartSkripsi)
    {
        $userID = auth()->user()->id;
        $dosenWali = Doswal::where('iduser', $userID)->first();

        $mahasiswaPerwalian = $dosenWali->mahasiswa;
        $jumlahMahasiswaPerwalian = $mahasiswaPerwalian->count();
        $jumlahMahasiswaAktif = $mahasiswaPerwalian->where('status', 'Aktif')->count();
        $jumlahMahasiswaCuti = $mahasiswaPerwalian->where('status', 'Cuti')->count();

        $chartPKL = $chartPKL->build();
        $chartSkripsi = $chartSkripsi->build();

        return view("doswal.dashboard", compact('dosenWali', 'mahasiswaPerwalian', 'jumlahMahasiswaPerwalian', 'jumlahMahasiswaAktif', 'jumlahMahasiswaCuti', 'chartPKL', 'chartSkripsi'));
    }

    public function viewDashboardDepartemen()
    {

        $mahasiswaCount = Mahasiswa::count();
        $mahasiswaAktifCount = Mahasiswa::where('status', 'Aktif')->count();
        $mahasiswaTidakAktifCount = Mahasiswa::whereIn('status', ['Tidak Aktif', 'Cuti', 'Mangkir', 'DO', 'Undur Diri', 'Lulus'])->count();


        return view("departemen.dashboard", compact("mahasiswaCount", "mahasiswaAktifCount", "mahasiswaTidakAktifCount"));
    }
}
