<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\IRS;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;

class DoswalController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        return view('doswal.profile', ["doswal" => $doswal]);
    }

    public function viewEditProfile()
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        return view('doswal.edit_profile', ["doswal" => $doswal]);
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $doswal = Doswal::where('iduser', $user->id)->first();


            $validated = $request->validate([
                'nama' => 'required',
                'nip' => 'required',
                'tahun_masuk' => 'required',
                'gelar_depan' => 'required',
                'gelar_belakang' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required',
                'username' => 'required',
                'foto' => 'nullable|image|max:10240',
            ]); 
        
            if ($request->has('foto')) {
                $fotoPath = $request->file('foto')->store('profile', 'public');
                $validated['foto'] = $fotoPath;

                $user->update([
                    'foto' => $validated['foto'],
                ]);
            }
            
            $doswal->nama = $request->nama;
            $doswal->nip = $request->nip;
            $doswal->tahun_masuk = $request->tahun_masuk;
            $doswal->gelar_depan = $request->gelar_depan;
            $doswal->gelar_belakang = $request->gelar_belakang;
            $doswal->alamat = $request->alamat;
            $doswal->nomor_telepon = $request->nomor_telepon;
            $doswal->username = $request->username;
            
            
            $doswal->save();

            $user->update([
                'username' => $request->username,
                'profile_completed' => 1
            ]);
            
            
            return redirect()->route('doswal.viewProfile')->with('success', 'Data dosen wali berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('doswal.viewProfile')->with('error', 'Terjadi kesalahan saat memperbarui data dosen wali.');
        }
    }

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

        return view('doswal.daftar_sudah_pkl', ['pklData' => $pklData]);
    }

    public function viewBelumPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('pkl.status', 'Tidak Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('doswal.daftar_belum_pkl', ['pklData' => $pklData]);
    }

    public function cetakSudahPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('pkl.status', 'Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.sudah_pkl_pdf', ['pklData' => $pklData]);
        return $pdf->download('rekap-sudah-pkl.pdf');
    }

    public function cetakBelumPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('pkl.status', 'Tidak Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.belum_pkl_pdf', ['pklData' => $pklData]);
        return $pdf->download('rekap-belum-pkl.pdf');
    }

    public function viewRekapSkripsi(Request $request)
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

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->get();

        $pklLulus = [];

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $skripsiData->where('angkatan', $tahun)->where('status', 'Lulus')->count();
            $skripsiLulus[$tahun] = $count;
        }

        $pklTidakLulus = [];

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $skripsiData->where('angkatan', $tahun)->where('status', 'Tidak Lulus')->count();
            $skripsiTidakLulus[$tahun] = $count;
        }
        
        return view('doswal.rekap_skripsi', ['skripsiData' => $skripsiData, 'daftarAngkatan' => $daftarAngkatan, 
                    'tahun1' => $tahun1, 'tahun2' => $tahun2,
                    'skripsiLulus' => $skripsiLulus, 'skripsiTidakLulus' => $skripsiTidakLulus]);
    }

    public function viewSudahSkripsi(int $angkatan)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('skripsi.status', 'Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('doswal.daftar_sudah_skripsi', ['skripsiData' => $skripsiData]);
    }

    public function viewBelumSkripsi(int $angkatan)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('skripsi.status', 'Tidak Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('doswal.daftar_belum_skripsi', ['skripsiData' => $skripsiData]);
    }

    public function cetakSudahSkripsi(int $angkatan)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('skripsi.status', 'Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.sudah_skripsi_pdf', ['skripsiData' => $skripsiData]);
        return $pdf->download('rekap-sudah-skripsi.pdf');
    }

    public function cetakBelumSkripsi(int $angkatan)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('skripsi.status', 'Tidak Lulus')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.belum_skripsi_pdf', ['skripsiData' => $skripsiData]);
        return $pdf->download('rekap-belum-skripsi.pdf');
    }

    public function viewRekapStatus(Request $request)
    {
        if($request->has('angkatan')) {
            $angkatan = $request->input('angkatan');
        } else {
            $angkatan = date('Y');
        }

        $daftarAngkatan = Mahasiswa::distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        $mhsData = Mahasiswa::where('angkatan', $angkatan);

        $aktif = $mhsData->where('status', 'Aktif')->count();
        $cuti = $mhsData->where('status', 'Cuti')->count();
        $mangkir = $mhsData->where('status', 'Mangkir')->count();
        $do = $mhsData->where('status', 'Drop Out')->count();
        $undurDiri = $mhsData->where('status', 'Undur Diri')->count();
        $lulus = $mhsData->where('status', 'Lulus')->count();
        $md = $mhsData->where('status', 'Meninggal Dunia')->count();
        
        return view('doswal.rekap_status', ['mhsData' => $mhsData, 'daftarAngkatan' => $daftarAngkatan, 'angkatan' => $angkatan, 'aktif' => $aktif, 'cuti' => $cuti, 
                    'mangkir' => $mangkir, 'do' => $do,
                    'undurDiri' => $undurDiri, 'lulus' => $lulus, 'md' => $md]);
    }
}

