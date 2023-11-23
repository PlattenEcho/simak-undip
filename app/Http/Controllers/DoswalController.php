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

        $allIRS = [];
        
        for ($i = 1; $i <= 14; $i++) {
            $allIRS[$i] = $mahasiswa->irs()->where('semester', $i)->where('status','1')->get(); 
            $allKHS[$i] = $mahasiswa->khs()->where('semester', $i)->where('status','1')->get(); 
            $PKL[$i] = $mahasiswa->pkl()->where('semester', $i)->where('statusVerif','1')->get(); 
            $skripsi[$i] = $mahasiswa->skripsi()->where('semester', $i)->where('statusVerif','1')->get(); 
        }
        
        return view('doswal.info_akademik', ['mahasiswa' => $mahasiswa, 'foto' => $foto,
                    'allIRS' => $allIRS, 'allKHS' => $allKHS, 'PKL' => $PKL, 'skripsi' => $skripsi]);
    }

    public function viewRekapPKL(Request $request)
    {
        if($request->has('tahun1')) {
            $tahun1 = $request->input('tahun1');
        } else {
            $tahun1 = date('Y') - 6;
        }
        
        if($request->has('tahun2')) {
            $tahun2 = $request->input('tahun2');
        } else {
            $tahun2 = date('Y');
        }

        if ($request->tahun1 > $request->tahun2) {
            return redirect()->route('doswal.viewRekapPKL')->with('error', 'Rentang tahun tidak valid.');
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

    public function cetakRekapPKL(int $tahun1, int $tahun2)
    {
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

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.cetak_rekap_pkl', ['pklData' => $pklData, 
                        'tahun1' => $tahun1, 'tahun2' => $tahun2,
                        'sudahPKL' => $sudahPKL, 'belumPKL' => $belumPKL]);
        return $pdf->stream('rekap-pkl.pdf');
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
        $pdf->loadView('doswal.cetak_sudah_pkl', ['pklData' => $pklData]);
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
        $pdf->loadView('doswal.cetak_belum_pkl', ['belumPKL' => $belumPKL]);
        return $pdf->stream('rekap-belum-pkl.pdf');
    }

    public function viewRekapSkripsi(Request $request)
    {
        if($request->has('tahun1')) {
            $tahun1 = $request->input('tahun1');
        } else {
            $tahun1 = date('Y') - 6;
        }
        
        if($request->has('tahun2')) {
            $tahun2 = $request->input('tahun2');
        } else {
            $tahun2 = date('Y');
        }

        if ($request->tahun1 > $request->tahun2) {
            return redirect()->route('doswal.viewRekapSkripsi')->with('error', 'Rentang tahun tidak valid.');
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

    public function cetakRekapSkripsi(int $tahun1, int $tahun2)
    {
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

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.cetak_rekap_skripsi', ['skripsiData' => $skripsiData,
                        'tahun1' => $tahun1, 'tahun2' => $tahun2,
                        'sudahSkripsi' => $sudahSkripsi, 'belumSkripsi' => $belumSkripsi]);
        return $pdf->stream('rekap-skripsi.pdf');
    }

    public function viewSudahSkripsi(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
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
        $pdf->loadView('doswal.cetak_sudah_skripsi', ['skripsiData' => $skripsiData]);
        return $pdf->stream('rekap-sudah-skripsi.pdf');
    }

    public function cetakBelumSkripsi(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('mahasiswa.nip', $doswal->nip)
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $skripsiNIM = $skripsiData->pluck('nim')->toArray();

        $belumSkripsi = Mahasiswa::where('nip', $doswal->nip)
                    ->where('angkatan', $angkatan)
                    ->whereNotIn('nim', $skripsiNIM)
                    ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.cetak_belum_skripsi', ['belumSkripsi' => $belumSkripsi]);
        return $pdf->stream('rekap-belum-skripsi.pdf');
    }

    public function viewRekapStatus(Request $request)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        if($request->has('angkatan')) {
            $angkatan = $request->input('angkatan');
        } else {
            $angkatan = Mahasiswa::where('nip', $doswal->nip)->max('angkatan');
        }

        $daftarAngkatan = Mahasiswa::where('nip', $doswal->nip)
                        ->distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        foreach ($daftarAngkatan as $angkatan) {
            $mhs = Mahasiswa::where('nip', $doswal->nip)
                ->where('angkatan', $angkatan);

            $jmlAktif = $mhs->where('status', 'Aktif')->count();
            $jmlCuti = $mhs->where('status', 'Cuti')->count();
            $jmlMangkir = $mhs->where('status', 'Mangkir')->count();
            $jmlDO = $mhs->where('status', 'Drop Out')->count();
            $jmlUndurDiri = $mhs->where('status', 'Undur Diri')->count();
            $jmlLulus = $mhs->where('status', 'Lulus')->count();
            $jmlMeninggal = $mhs->where('status', 'Meninggal Dunia')->count();
        
            $aktif[$angkatan] = $jmlAktif;
            $cuti[$angkatan] = $jmlCuti;
            $mangkir[$angkatan] = $jmlMangkir;
            $do[$angkatan] = $jmlDO;
            $undurDiri[$angkatan] = $jmlUndurDiri;
            $lulus[$angkatan] = $jmlLulus;
            $md[$angkatan] = $jmlMeninggal;
        }

        //$mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->get();
        
        return view('doswal.rekap_status', ['daftarAngkatan' => $daftarAngkatan, 'angkatan' => $angkatan, 'aktif' => $aktif, 'cuti' => $cuti, 
                    'mangkir' => $mangkir, 'do' => $do,
                    'undurDiri' => $undurDiri, 'lulus' => $lulus, 'md' => $md]);
    }

    public function cetakRekapStatus()
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $daftarAngkatan = Mahasiswa::where('nip', $doswal->nip)
                        ->distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        foreach ($daftarAngkatan as $angkatan) {
            $mhs = Mahasiswa::where('nip', $doswal->nip)
                ->where('angkatan', $angkatan);

            $jmlAktif = $mhs->where('status', 'Aktif')->count();
            $jmlCuti = $mhs->where('status', 'Cuti')->count();
            $jmlMangkir = $mhs->where('status', 'Mangkir')->count();
            $jmlDO = $mhs->where('status', 'Drop Out')->count();
            $jmlUndurDiri = $mhs->where('status', 'Undur Diri')->count();
            $jmlLulus = $mhs->where('status', 'Lulus')->count();
            $jmlMeninggal = $mhs->where('status', 'Meninggal Dunia')->count();
        
            $aktif[$angkatan] = $jmlAktif;
            $cuti[$angkatan] = $jmlCuti;
            $mangkir[$angkatan] = $jmlMangkir;
            $do[$angkatan] = $jmlDO;
            $undurDiri[$angkatan] = $jmlUndurDiri;
            $lulus[$angkatan] = $jmlLulus;
            $md[$angkatan] = $jmlMeninggal;
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.cetak_rekap_status', ['daftarAngkatan' => $daftarAngkatan, 'angkatan' => $angkatan, 'aktif' => $aktif, 'cuti' => $cuti, 
        'mangkir' => $mangkir, 'do' => $do,
        'undurDiri' => $undurDiri, 'lulus' => $lulus, 'md' => $md]);
        return $pdf->stream('rekap-status.pdf');
    }

    public function viewDaftarMhsStatus(int $angkatan, string $status)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', $status)->get();

        return view('doswal.daftar_mhs_status', ['mhsData' => $mhsData, 'status' => $status]);
    }

    public function cetakDaftarMhsStatus(int $angkatan, string $status)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', $status)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doswal.cetak_mhs_status', ['mhsData' => $mhsData, 'status' => $status]);
        return $pdf->stream('daftar-mhs.pdf');
    }

    public function viewDaftarCuti(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', 'Cuti')->get();

        return view('doswal.daftar_status_cuti', ['mhsData' => $mhsData]);
    }

    public function viewDaftarMangkir(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', 'Mangkir')->get();

        return view('doswal.daftar_status_mangkir', ['mhsData' => $mhsData]);
    }

    public function viewDaftarDO(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', 'Drop Out')->get();

        return view('doswal.daftar_status_do', ['mhsData' => $mhsData]);
    }

    public function viewDaftarUndurDiri(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', 'Undur Diri')->get();

        return view('doswal.daftar_status_undurdiri', ['mhsData' => $mhsData]);
    }

    public function viewDaftarLulus(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', 'Lulus')->get();

        return view('doswal.daftar_status_lulus', ['mhsData' => $mhsData]);
    }

    public function viewDaftarMeninggal(int $angkatan)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::where('nip', $doswal->nip)->where('angkatan', $angkatan)->where('status', 'Meninggal')->get();

        return view('doswal.daftar_status_meninggal', ['mhsData' => $mhsData]);
    }
}


