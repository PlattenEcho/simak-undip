<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\IRS;
use App\Models\KHS;
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
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first(); 

        $irsData = IRS::with('mahasiswa')->where('status', '0')->where('nama_doswal',$doswal->nama)->get();

        $semesters = IRS::where('status', '0')
                        ->where('nama_doswal',$doswal->nama)
                        ->distinct()
                        ->pluck('semester')
                        ->toArray();

        return view('doswal.verifikasi_irs', ['semesters' => $semesters, 'irsData' => $irsData]);
    }

    public function viewVerifikasiKHS()
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $khsData = KHS::with('mahasiswa')->where('status', "0")->where('nama_doswal',$doswal->nama)->get();

        $semesters = KHS::where('status', 0)
                        ->where('nama_doswal',$doswal->nama)
                        ->distinct()
                        ->pluck('semester')
                        ->toArray();

        return view('doswal.verifikasi_khs', ['semesters' => $semesters, 'khsData' => $khsData]);
    }

    public function viewVerifikasiPKL()
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first(); 

        $pklData = PKL::with('mahasiswa')->where('statusVerif', '0')->where('nama_doswal',$doswal->nama)->get();
        
        $semesters = PKL::where('statusVerif', '0')
                        ->where('nama_doswal',$doswal->nama)
                        ->distinct()
                        ->pluck('semester')
                        ->toArray();

        return view('doswal.verifikasi_pkl', ['semesters' => $semesters, 'pklData' => $pklData]);
    }

    public function viewVerifikasiSkripsi()
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first(); 

        $skripsiData = Skripsi::with('mahasiswa')->where('statusVerif', '0')->where('nama_doswal',$doswal->nama)->get();
        
        $semesters = Skripsi::where('statusVerif', '0')
                        ->where('nama_doswal',$doswal->nama)
                        ->distinct()
                        ->pluck('semester')
                        ->toArray();

        return view('doswal.verifikasi_skripsi', ['semesters' => $semesters, 'skripsiData' => $skripsiData]);
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

        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('statusVerif', '1')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->get();

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $pklData->where('angkatan', $tahun)->where('statusVerif', '1')->count();
            $sudahPKL[$tahun] = $count;
        }

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $allNIM = Mahasiswa::where('nip',$doswal->nip)->where('angkatan',$tahun)->pluck('nim')->toArray();
            $pklNIM = $pklData->where('angkatan', $tahun)->where('statusVerif', '1')->pluck('nim')->toArray();
            $belumPKL[$tahun] = count(array_diff($allNIM, $pklNIM));
        }
        
        return view('doswal.rekap_pkl', ['pklData' => $pklData, 'daftarAngkatan' => $daftarAngkatan, 
                    'tahun1' => $tahun1, 'tahun2' => $tahun2,
                    'sudahPKL' => $sudahPKL, 'belumPKL' => $belumPKL]);
    }

    public function viewSudahPKL(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('doswal.daftar_sudah_pkl', ['pklData' => $pklData]);
    }

    public function viewBelumPKL(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();
         
        $pklNIM = $pklData->pluck('nim')->toArray();

        $belumPKL = Mahasiswa::where('nip', $doswal->nip)
                    ->where('angkatan', $angkatan)
                    ->whereNotIn('nim', $pklNIM)
                    ->get();

        return view('doswal.daftar_belum_pkl', ['belumPKL' => $belumPKL]);
    }

    public function cetakSudahPKL(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.sudah_pkl_pdf', ['pklData' => $pklData]);
        return $pdf->stream('rekap-sudah-pkl.pdf');
    }

    public function cetakBelumPKL(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();
         
        $pklNIM = $pklData->pluck('nim')->toArray();

        $belumPKL = Mahasiswa::where('nip', $doswal->nip)
                    ->where('angkatan', $angkatan)
                    ->whereNotIn('nim', $pklNIM)
                    ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.belum_pkl_pdf', ['belumPKL' => $belumPKL]);
        return $pdf->stream('rekap-belum-pkl.pdf');
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

        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('statusVerif', '1')
                        ->get();

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $skripsiData->where('angkatan', $tahun)->count();
            $sudahSkripsi[$tahun] = $count;
        }

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $allNIM = Mahasiswa::where('nip',$doswal->nip)->where('angkatan',$tahun)->pluck('nim')->toArray();
            $skripsiNIM = $skripsiData->where('angkatan', $tahun)->where('statusVerif', '1')->pluck('nim')->toArray();
            $belumSkripsi[$tahun] = count(array_diff($allNIM, $skripsiNIM));
        }
        
        return view('doswal.rekap_skripsi', ['skripsiData' => $skripsiData, 'daftarAngkatan' => $daftarAngkatan, 
                    'tahun1' => $tahun1, 'tahun2' => $tahun2,
                    'sudahSkripsi' => $sudahSkripsi, 'belumSkripsi' => $belumSkripsi]);
    }

    public function viewSudahSkripsi(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('skripsi.status', 'Lulus')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('doswal.daftar_sudah_skripsi', ['skripsiData' => $skripsiData]);
    }

    public function viewBelumSkripsi(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('skripsi.status', 'Tidak Lulus')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $skripsiNIM = $skripsiData->pluck('nim')->toArray();

        $belumSkripsi = Mahasiswa::where('nip', $doswal->nip)
                    ->where('angkatan', $angkatan)
                    ->whereNotIn('nim', $skripsiNIM)
                    ->get();

        return view('doswal.daftar_belum_skripsi', ['belumSkripsi' => $belumSkripsi]);
    }

    public function cetakSudahSkripsi(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('skripsi.status', 'Lulus')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.sudah_skripsi_pdf', ['skripsiData' => $skripsiData]);
        return $pdf->stream('rekap-sudah-skripsi.pdf');
    }

    public function cetakBelumSkripsi(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('skripsi.status', 'Tidak Lulus')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $skripsiNIM = $skripsiData->pluck('nim')->toArray();

        $belumSkripsi = Mahasiswa::where('nip', $doswal->nip)
                    ->where('angkatan', $angkatan)
                    ->whereNotIn('nim', $skripsiNIM)
                    ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.belum_skripsi_pdf', ['belumSkripsi' => $belumSkripsi]);
        return $pdf->stream('rekap-belum-skripsi.pdf');
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

        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->get();

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

    public function viewDaftarAktif(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', 'Aktif')->get();

        return view('doswal.daftar_aktif', ['mhsData' => $mhsData]);
    }

}


