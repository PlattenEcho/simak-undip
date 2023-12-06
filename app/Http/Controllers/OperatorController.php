<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\GeneratedAccount;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Operator;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\User;

class OperatorController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user();
        $operator = Operator::where('iduser', $user->id)->first();
        return view('operator.profile', ["operator" => $operator]);
    }

    public function viewEditProfile()
    {
        $user = Auth::user();
        $operator = Operator::where('iduser', $user->id)->first();

        return view('operator.edit_profile', ["operator" => $operator]);
    }

    public function viewEditStatus(string $nim)
    {
        $dosen_wali = Doswal::all();
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        return view('operator.edit_status', ["mahasiswa" => $mahasiswa, 'dosen_wali' => $dosen_wali]);
    }

    public function delete2($nim)
    {
        try {
            $mahasiswa = Mahasiswa::where('nim', $nim)->first();
            
            $mahasiswa->delete();

            return redirect()->back()->with('success', 'Berhasil menghapus data mahasiswa.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data mahasiswa.');
        }
    }
    public function update2(Request $request, string $nim)
{
    try {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $user = User::where('username', $mahasiswa->username)->first();

        $validated = $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'nomor_telepon' => 'nullable|numeric',
            'alamat' => 'nullable',
            'provinsi' => 'nullable',
            'kabupaten' => 'nullable',
            'status' => 'required|in:Aktif,Cuti,Mangkir,DO,Undur Diri,Lulus,Meninggal Dunia',
            'username' => 'required|unique:users,username,' . $mahasiswa->users->id,
            'foto' => 'nullable|image|max:10240',
        ]);

        if ($request->has('foto')) {
            $fotoPath = $request->file('foto')->store('profile', 'public');
            $validated['foto'] = $fotoPath;

            $user->update([
                'foto' => $validated['foto'],
            ]);
        }

        $mahasiswa->nama = $request->nama;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->username = $request->username;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->nomor_telepon = $request->nomor_telepon;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->nip = $request->doswal;
        $mahasiswa->provinsi = $request->provinsi;
        $mahasiswa->kabupaten = $request->kabupaten;
        $mahasiswa->status = $request->status;

        $mahasiswa->save();

        $user->update([
            'username' => $request->username
        ]);

            return redirect()->route('operator.viewDaftarMhs')->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            
            return redirect()->route('operator.viewDaftarMhs')->with('error', 'Terjadi kesalahan saat memperbarui profil mahasiswa.');
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $operator = Operator::where('iduser', $user->id)->first();

            $validated = $request->validate([
                'nama' => 'required',
                'nip' => 'required',
                'tahun_masuk' => 'required',
                'alamat' => 'required',
                'no_telepon' => 'required',
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
            
            $operator->nama = $request->nama;
            $operator->nip = $request->nip;
            $operator->tahun_masuk = $request->tahun_masuk;
            $operator->alamat = $request->alamat;
            $operator->no_telepon = $request->no_telepon;
            $operator->username = $request->username;
            
            $operator->save();

            $user->update([
                'username' => $request->username,
                'profile_completed' => 1
            ]);
            
            return redirect()->route('operator.viewProfile')->with('success', 'Data operator berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('operator.viewProfile')->with('error', 'Terjadi kesalahan saat memperbarui data operator.');
        }
    }
    

    public function cetakDaftarAkun()
    {
        $accounts = GeneratedAccount::all();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.daftar_akun_pdf', ['accounts' => $accounts]);
        return $pdf->stream('daftar_akun.pdf');
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

        return view('operator.daftar_mhs', ['mhsData' => $mhsData]);
    }   
    public function viewDaftarMhs()
    {
        $user = Auth::user();
        $operator = Operator::where('iduser', $user->id)->first();
        $mhsData = Mahasiswa::all();

        return view('operator.daftar_mhs', ['mhsData' => $mhsData]);
    }

    public function viewInfoAkademik(string $nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $foto = User::where('id',$mahasiswa->iduser)->first()->getImageURL();
        $allSemester = range(1, 14);
        $semester = request()->query('semester'); 

        $allIRS = [];
        
        for ($i = 1; $i <= 14; $i++) {
            $allIRS[$i] = $mahasiswa->irs()->where('semester', $i)->get(); 
            $allKHS[$i] = $mahasiswa->khs()->where('semester', $i)->get(); 
            $PKL[$i] = $mahasiswa->pkl()->where('semester', $i)->get(); 
            $skripsi[$i] = $mahasiswa->skripsi()->where('semester', $i)->get(); 
        }
    
        $irs = $mahasiswa->irs()
            ->where('semester', $semester)
            ->first();

        $khs = $mahasiswa->khs()
            ->where('semester', $semester)
            ->first();

        return view('operator.info_akademik', ['mahasiswa' => $mahasiswa, 'foto' => $foto, 'allSemester' => $allSemester, 
                    'irs' => $irs, 'khs' => $khs,  
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
            return redirect()->route('operator.viewRekapPKL')->with('error', 'Rentang tahun tidak valid.');
        }

        $daftarAngkatan = Mahasiswa::distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->where('statusVerif', '1')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->get();

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $pklData->where('angkatan', $tahun)->where('statusVerif', '1')->count();
            $sudahPKL[$tahun] = $count;
        }

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $allNIM = Mahasiswa::where('angkatan',$tahun)->pluck('nim')->toArray();
            $pklNIM = $pklData->where('angkatan', $tahun)->where('statusVerif', '1')->pluck('nim')->toArray();
            $belumPKL[$tahun] = count(array_diff($allNIM, $pklNIM));
        }
        
        return view('operator.rekap_pkl', ['pklData' => $pklData, 'daftarAngkatan' => $daftarAngkatan, 
                    'tahun1' => $tahun1, 'tahun2' => $tahun2,
                    'sudahPKL' => $sudahPKL, 'belumPKL' => $belumPKL]);
    }

    public function cetakRekapPKL(int $tahun1, int $tahun2)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->where('statusVerif', '1')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->get();

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $pklData->where('angkatan', $tahun)->where('statusVerif', '1')->count();
            $sudahPKL[$tahun] = $count;
        }

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $allNIM = Mahasiswa::where('angkatan',$tahun)->pluck('nim')->toArray();
            $pklNIM = $pklData->where('angkatan', $tahun)->where('statusVerif', '1')->pluck('nim')->toArray();
            $belumPKL[$tahun] = count(array_diff($allNIM, $pklNIM));
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.cetak_rekap_pkl', ['pklData' => $pklData, 
                        'tahun1' => $tahun1, 'tahun2' => $tahun2,
                        'sudahPKL' => $sudahPKL, 'belumPKL' => $belumPKL]);
        return $pdf->stream('rekap-pkl.pdf');
    }

    public function viewSudahPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('operator.daftar_sudah_pkl', ['pklData' => $pklData]);
    }

    public function viewBelumPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();
         
        $pklNIM = $pklData->pluck('nim')->toArray();

        $belumPKL = Mahasiswa::where('angkatan', $angkatan)
                    ->whereNotIn('nim', $pklNIM)
                    ->get();

        return view('operator.daftar_belum_pkl', ['belumPKL' => $belumPKL]);
    }

    public function cetakSudahPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.cetak_sudah_pkl', ['pklData' => $pklData]);
        return $pdf->stream('rekap-sudah-pkl.pdf');
    }

    public function cetakBelumPKL(int $angkatan)
    {
        $pklData = PKL::join('mahasiswa', 'pkl.nim', '=', 'mahasiswa.nim')
                        ->select('pkl.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();
         
        $pklNIM = $pklData->pluck('nim')->toArray();

        $belumPKL = Mahasiswa::where('angkatan', $angkatan)
                    ->whereNotIn('nim', $pklNIM)
                    ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.cetak_belum_pkl', ['belumPKL' => $belumPKL]);
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
            return redirect()->route('operator.viewRekapSkripsi')->with('error', 'Rentang tahun tidak valid.');
        }

        $daftarAngkatan = Mahasiswa::distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->get();

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $skripsiData->where('angkatan', $tahun)->count();
            $sudahSkripsi[$tahun] = $count;
        }

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $allNIM = Mahasiswa::where('angkatan',$tahun)->pluck('nim')->toArray();
            $skripsiNIM = $skripsiData->where('angkatan', $tahun)->where('statusVerif', '1')->pluck('nim')->toArray();
            $belumSkripsi[$tahun] = count(array_diff($allNIM, $skripsiNIM));
        }
        
        return view('operator.rekap_skripsi', ['skripsiData' => $skripsiData, 'daftarAngkatan' => $daftarAngkatan, 
                    'tahun1' => $tahun1, 'tahun2' => $tahun2,
                    'sudahSkripsi' => $sudahSkripsi, 'belumSkripsi' => $belumSkripsi]);
    }

    public function cetakRekapSkripsi(int $tahun1, int $tahun2)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->get();

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $count = $skripsiData->where('angkatan', $tahun)->count();
            $sudahSkripsi[$tahun] = $count;
        }

        for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++) {
            $allNIM = Mahasiswa::where('angkatan',$tahun)->pluck('nim')->toArray();
            $skripsiNIM = $skripsiData->where('angkatan', $tahun)->where('statusVerif', '1')->pluck('nim')->toArray();
            $belumSkripsi[$tahun] = count(array_diff($allNIM, $skripsiNIM));
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.cetak_rekap_skripsi', ['skripsiData' => $skripsiData,
                        'tahun1' => $tahun1, 'tahun2' => $tahun2,
                        'sudahSkripsi' => $sudahSkripsi, 'belumSkripsi' => $belumSkripsi]);
        return $pdf->stream('rekap-skripsi.pdf');
    }

    public function viewSudahSkripsi(int $angkatan)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        return view('operator.daftar_sudah_skripsi', ['skripsiData' => $skripsiData]);
    }

    public function viewBelumSkripsi(int $angkatan)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $skripsiNIM = $skripsiData->pluck('nim')->toArray();

        $belumSkripsi = Mahasiswa::where('angkatan', $angkatan)
                    ->whereNotIn('nim', $skripsiNIM)
                    ->get();

        return view('operator.daftar_belum_skripsi', ['belumSkripsi' => $belumSkripsi]);
    }

    public function cetakSudahSkripsi(int $angkatan)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('skripsi.status', 'Lulus')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.cetak_sudah_skripsi', ['skripsiData' => $skripsiData]);
        return $pdf->stream('rekap-sudah-skripsi.pdf');
    }

    public function cetakBelumSkripsi(int $angkatan)
    {
        $skripsiData = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
                        ->select('skripsi.*', 'mahasiswa.angkatan')
                        ->where('statusVerif', '1')
                        ->where('mahasiswa.angkatan', $angkatan)
                        ->get();

        $skripsiNIM = $skripsiData->pluck('nim')->toArray();

        $belumSkripsi = Mahasiswa::where('angkatan', $angkatan)
                    ->whereNotIn('nim', $skripsiNIM)
                    ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.cetak_belum_skripsi', ['belumSkripsi' => $belumSkripsi]);
        return $pdf->stream('rekap-belum-skripsi.pdf');
    }

    public function viewRekapStatus(Request $request)
    {
        $angkatanTampil = date('Y') - 6;

        if($request->has('angkatan')) {
            $angkatan = $request->input('angkatan');
        } else {
            $angkatan = Mahasiswa::max('angkatan');
        }

        $daftarAngkatan = Mahasiswa::distinct()
                        ->where('angkatan','>=', $angkatanTampil)
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        foreach ($daftarAngkatan as $angkatan) {
            $mhs = Mahasiswa::where('angkatan', $angkatan);

            $jmlAktif = clone $mhs;
            $jmlAktif = $jmlAktif->where('status', 'Aktif')->count();
            $jmlCuti = clone $mhs;
            $jmlCuti = $jmlCuti->where('status', 'Cuti')->count();
            $jmlMangkir = clone $mhs;
            $jmlMangkir = $jmlMangkir->where('status', 'Mangkir')->count();
            $jmlDO = clone $mhs;
            $jmlDO = $jmlDO->where('status', 'Drop Out')->count();
            $jmlUndurDiri = clone $mhs;
            $jmlUndurDiri = $jmlUndurDiri->where('status', 'Undur Diri')->count();
            $jmlLulus = clone $mhs;
            $jmlLulus = $jmlLulus->where('status', 'Lulus')->count();
            $jmlMeninggal = clone $mhs;
            $jmlMeninggal = $jmlMeninggal->where('status', 'Meninggal Dunia')->count();
            
            $aktif[$angkatan] = $jmlAktif;
            $cuti[$angkatan] = $jmlCuti;
            $mangkir[$angkatan] = $jmlMangkir;
            $do[$angkatan] = $jmlDO;
            $undurDiri[$angkatan] = $jmlUndurDiri;
            $lulus[$angkatan] = $jmlLulus;
            $md[$angkatan] = $jmlMeninggal;
        }
        return view('operator.rekap_status', ['daftarAngkatan' => $daftarAngkatan, 'angkatan' => $angkatan, 'aktif' => $aktif, 'cuti' => $cuti, 
                    'mangkir' => $mangkir, 'do' => $do,
                    'undurDiri' => $undurDiri, 'lulus' => $lulus, 'md' => $md]);
    }

    public function cetakRekapStatus()
    {
       $daftarAngkatan = Mahasiswa::distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        foreach ($daftarAngkatan as $angkatan) {
            $mhs = Mahasiswa::where('angkatan', $angkatan);

            $jmlAktif = clone $mhs;
            $jmlAktif = $mhs->where('status', 'Aktif')->count();
            $jmlCuti = clone $mhs;
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
        $pdf->loadView('operator.cetak_rekap_status', ['daftarAngkatan' => $daftarAngkatan, 'angkatan' => $angkatan, 'aktif' => $aktif, 'cuti' => $cuti, 
        'mangkir' => $mangkir, 'do' => $do,
        'undurDiri' => $undurDiri, 'lulus' => $lulus, 'md' => $md]);
        return $pdf->stream('rekap-status.pdf');
    }

    public function viewDaftarMhsStatus(int $angkatan, string $status)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', $status)->get();

        return view('operator.daftar_mhs_status', ['mhsData' => $mhsData, 'status' => $status]);
    }

    public function cetakDaftarMhsStatus(int $angkatan, string $status)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', $status)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.cetak_mhs_status', ['mhsData' => $mhsData, 'status' => $status]);
        return $pdf->stream('daftar-mhs.pdf');
    }
}

