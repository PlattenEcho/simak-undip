<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KHSController extends Controller
{
    public function viewKHS()
    {
        return view('mahasiswa.khs');
    }

    public function viewEntryKHS(Request $request)
    {
        $semesters = KHS::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(1, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('mahasiswa.entry_khs', ['remainingSemesters' => $remainingSemesters]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'sks_smt' => 'required|numeric',
            'sks_kum' => 'required|numeric',
            'ips' => 'required|double',
            'ipk' => 'required|double',
            'scan_khs' => 'required|max:5120',
        ]);
        
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();

        try {
            KHS::create([
            'nim' => $mahasiswa->nim, 
            'semester' => $request->semester,
            'sks_smt' => $request->sks_smt,
            'sks_kum' => $request->sks_kum,
            'ips' => $request->ips,
            'ipk' => $request->ipk,
            'scan_khs' => $request->scan_khs,
            'namaMhs' => $mahasiswa->nama,
            'namaDoswal' => $mahasiswa->dosen_wali->nama,
            ]);
        } catch (\Exception $e) {
            $errorMessage = 'Gagal menyimpan data KHS.';
        }
    
        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success',  'Data KHS berhasil disimpan.');
        }
    
        return redirect()->route('khs.viewKHS');
    }
}
