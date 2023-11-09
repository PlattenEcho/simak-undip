<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Mahasiswa;
use App\Models\PKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartemenController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user();
        $departemen = Departemen::where('iduser', $user->id)->first();
        return view('departemen.profile', ["departemen" => $departemen]);
    }

    public function viewEditProfile()
    {
        $user = Auth::user();
        $departemen = Departemen::where('iduser', $user->id)->first();

        return view('departemen.edit_profile', ["departemen" => $departemen]);
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $departemen = Departemen::where('iduser', $user->id)->first();


            $validated = $request->validate([
                'nama' => 'required',
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
            
            $departemen->nama = $request->nama;
            $departemen->alamat = $request->alamat;
            $departemen->no_telepon = $request->no_telepon;
            $departemen->username = $request->username;
            
            
            $departemen->save();

            $user->update([
                'username' => $request->username,
                'profile_completed' => 1
            ]);
            
            
            return redirect()->route('departemen.viewProfile')->with('success', 'Data departemen berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('departemen.viewProfile')->with('error', 'Terjadi kesalahan saat memperbarui data departemen.');
        }
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

        return view('departemen.rekap_status', ['mhsData' => $mhsData, 'daftarAngkatan' => $daftarAngkatan, 'angkatan' => $angkatan, 'aktif' => $aktif, 'cuti' => $cuti, 
                    'mangkir' => $mangkir, 'do' => $do,
                    'undurDiri' => $undurDiri, 'lulus' => $lulus, 'md' => $md]);
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
        
        return view('departemen.rekap_pkl', ['pklData' => $pklData, 'daftarAngkatan' => $daftarAngkatan, 
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

        return view('departemen.daftar_sudah_pkl', ['pklData' => $pklData]);
    }
}
