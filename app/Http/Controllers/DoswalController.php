<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\IRS;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoswalController extends Controller
{
    public function searchMahasiswa(Request $request)
    {
        $search = $request->input('search');

        if (!empty($search)) {
            $mhsData = Mahasiswa::where(function($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nim', 'like', '%' . $search . '%');
            })->get();
        } 

        return view('doswal.daftar_mhs', ['mhsData' => $mhsData]);
    }   
    
    public function viewDaftarMhs()
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = $doswal->mahasiswa;

        return view('doswal.daftar_mhs', ['mhsData' => $mhsData]);
    }

    public function viewVerifikasiIRS()
    {
        $irsData = IRS::with('mahasiswa')->where('status', 'Unverified')->get();

        $semesters = IRS::where('status', 'Unverified')
                        ->distinct()
                        ->pluck('semester')
                        ->toArray();

        return view('doswal.verifikasi_irs', ['semesters' => $semesters, 'irsData' => $irsData]);
    }

    public function filterIRS(Request $request)
    {
        $semester = $request->input('filter');

        if ($semester == 'all') {
            $irsData = IRS::with('mahasiswa')
            ->where('status', 'Unverified')
            ->get();
        } else {
            $irsData = IRS::with('mahasiswa')
            ->where('semester', $semester)
            ->where('status', 'Unverified')
            ->get();
        }
        
        $semesters = IRS::where('status', 'Unverified')
                        ->distinct()
                        ->pluck('semester')
                        ->toArray();

        return view('doswal.verifikasi_irs', ['semesters' => $semesters, 'irsData' => $irsData]);
    } 

    public function viewInfoAkademik(string $nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $foto = User::where('id',$mahasiswa->iduser)->first()->getImageURL();
        $allSemester = range(1, 14);
        $semester = request()->query('semester'); 
        
        $irs = $mahasiswa->irs()
            ->where('semester', $semester)
            ->first();

        $khs = $mahasiswa->khs()
            ->where('semester', $semester)
            ->first();

        $pkl = $mahasiswa->pkl()
            ->where('nim', $nim)
            ->first();

        $skripsi = $mahasiswa->skripsi()
            ->where('nim', $nim)
            ->first();
        
        return view('doswal.info_akademik', ['mahasiswa' => $mahasiswa, 'foto' => $foto, 'allSemester' => $allSemester, 
                    'irs' => $irs, 'khs' => $khs, 'pkl' => $pkl, 'skripsi' => $skripsi]);
    }

}
