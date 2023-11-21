<?php

namespace App\Http\Controllers;

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
        
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        return view('operator.edit_status', ["mahasiswa" => $mahasiswa]);
    }

    public function update2(Request $request)
{
    try {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('iduser', $user->id)->first();

        $validated = $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'nomor_telepon' => 'required|numeric',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'status' => 'required|in:Aktif,Cuti,Mangkir,DO,Undur Diri,Lulus,Meninggal Dunia',
            'username' => 'required|unique:users,username,' . $user->id,
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
        $mahasiswa->nomor_telepon = $request->nomor_telepon;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->provinsi = $request->provinsi;
        $mahasiswa->kabupaten = $request->kabupaten;
        $mahasiswa->status = $request->status;

        $mahasiswa->save();

        $user->update([
            'username' => $request->username,
            'profile_completed' => 1
        ]);

            return redirect()->route('operator.viewDaftarMhs')->with('success', 'Status mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e);
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
        if($request->has('angkatan')) {
            $angkatan = $request->input('angkatan');
        } else {
            $angkatan = Mahasiswa::max('angkatan');
        }

        $daftarAngkatan = Mahasiswa::distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        $mhsData = Mahasiswa::where('angkatan', $angkatan)->get();

        $aktif = $mhsData->where('status', 'Aktif')->count();
        $cuti = $mhsData->where('status', 'Cuti')->count();
        $mangkir = $mhsData->where('status', 'Mangkir')->count();
        $do = $mhsData->where('status', 'Drop Out')->count();
        $undurDiri = $mhsData->where('status', 'Undur Diri')->count();
        $lulus = $mhsData->where('status', 'Lulus')->count();
        $md = $mhsData->where('status', 'Meninggal Dunia')->count();
        
        return view('operator.rekap_status', ['mhsData' => $mhsData, 'daftarAngkatan' => $daftarAngkatan, 'angkatan' => $angkatan, 'aktif' => $aktif, 'cuti' => $cuti, 
                    'mangkir' => $mangkir, 'do' => $do,
                    'undurDiri' => $undurDiri, 'lulus' => $lulus, 'md' => $md]);
    }

    public function cetakRekapStatus(int $tahun)
    {
        $daftarAngkatan = Mahasiswa::distinct()
                        ->orderBy('angkatan', 'asc')
                        ->pluck('angkatan')
                        ->toArray();

        $mhsData = Mahasiswa::where('angkatan', $tahun)->get();

        $aktif = $mhsData->where('status', 'Aktif')->count();
        $cuti = $mhsData->where('status', 'Cuti')->count();
        $mangkir = $mhsData->where('status', 'Mangkir')->count();
        $do = $mhsData->where('status', 'Drop Out')->count();
        $undurDiri = $mhsData->where('status', 'Undur Diri')->count();
        $lulus = $mhsData->where('status', 'Lulus')->count();
        $md = $mhsData->where('status', 'Meninggal Dunia')->count();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.cetak_rekap_status', ['mhsData' => $mhsData, 'daftarAngkatan' => $daftarAngkatan, 'angkatan' => $tahun, 'aktif' => $aktif, 'cuti' => $cuti, 
                        'mangkir' => $mangkir, 'do' => $do,
                        'undurDiri' => $undurDiri, 'lulus' => $lulus, 'md' => $md]);
        return $pdf->stream('rekap-status.pdf');
    }

    public function viewDaftarAktif(int $angkatan)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', 'Aktif')->get();

        return view('operator.daftar_status_aktif', ['mhsData' => $mhsData]);
    }

    public function viewDaftarCuti(int $angkatan)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', 'Cuti')->get();

        return view('operator.daftar_status_cuti', ['mhsData' => $mhsData]);
    }

    public function viewDaftarMangkir(int $angkatan)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', 'Mangkir')->get();

        return view('operator.daftar_status_mangkir', ['mhsData' => $mhsData]);
    }

    public function viewDaftarDO(int $angkatan)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', 'Drop Out')->get();

        return view('operator.daftar_status_do', ['mhsData' => $mhsData]);
    }

    public function viewDaftarUndurDiri(int $angkatan)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', 'Undur Diri')->get();

        return view('operator.daftar_status_undurdiri', ['mhsData' => $mhsData]);
    }

    public function viewDaftarLulus(int $angkatan)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', 'Lulus')->get();

        return view('operator.daftar_status_lulus', ['mhsData' => $mhsData]);
    }

    public function viewDaftarMeninggal(int $angkatan)
    {
        $mhsData = Mahasiswa::where('angkatan', $angkatan)->where('status', 'Meninggal')->get();

        return view('operator.daftar_status_meninggal', ['mhsData' => $mhsData]);
    }
}

