<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\IRS;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
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

    public function viewRekapPKL(Request $request)
    {
        if($request->has('tahun1')) {
            $tahun1 = $request->input('tahun1');
        } else {
            $tahun1 = date('Y') - 4;
        }
        
        if($request->has('tahun2')) {
            $tahun2 = $request->input('tahun2');
        } else {
            $tahun2 = date('Y');
        }

        $daftarAngkatan = Mahasiswa::distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->get();

        $pklLulus = [];

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $pklData->where('angkatan', $tahun)->where('status', 'Lulus')->count();
            $pklLulus[$tahun] = $count;
        }

        $pklTidakLulus = [];

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $pklData->where('angkatan', $tahun)->where('status', 'Tidak Lulus')->count();
            $pklTidakLulus[$tahun] = $count;
        }
        
        return view('doswal.rekap_pkl', ['pklData' => $pklData, 'daftarAngkatan' => $daftarAngkatan, 
                    'tahun1' => $tahun1, 'tahun2' => $tahun2,
                    'pklLulus' => $pklLulus, 'pklTidakLulus' => $pklTidakLulus]);
    }

    public function viewSudahPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('pkl.status', 'Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('doswal.detail_sudah_pkl', ['pklData' => $pklData]);
    }

    public function viewBelumPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('pkl.status', 'Tidak Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('doswal.detail_belum_pkl', ['pklData' => $pklData]);
    }

    public function cetakPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('pkl.status', 'Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();
    
        // $pdf = PDF::loadview('viewSudahPKL',['pklData'=>$pklData]);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.sudah_pkl_pdf', ['pklData' => $pklData]);
        return $pdf->stream('rekap-sudah-pkl-pdf');

        //return $pdf->download('rekap-sudah-pkl-pdf');
    }
}
