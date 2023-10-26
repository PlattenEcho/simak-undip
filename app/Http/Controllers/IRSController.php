<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IRSController extends Controller
{
    public function viewIRS()
    {
        return view('mahasiswa.irs');
    }

    public function viewEntryIRS(Request $request)
    {   
        $semesters = IRS::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(1, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('mahasiswa.entry_irs', ['remainingSemesters' => $remainingSemesters]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'jml_sks' => 'required|numeric',
            'scan_irs' => 'required|max:5120',
        ]);
        
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();

        try {
            IRS::create([
            'nim' => $mahasiswa->nim, 
            'semester' => $request->semester,
            'jml_sks' => $request->jml_sks,
            'scan_irs' => $request->scan_irs,
            'nama_mhs' => $mahasiswa->nama,
            'nama_doswal' => $mahasiswa->dosen_wali->nama,
            ]);
        } catch (\Exception $e) {
            $errorMessage = 'Gagal menyimpan data IRS.';
        }
    
        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success',  'Data IRS berhasil disimpan.');
        }
    
        return redirect()->route('irs.viewIRS');
    }
}
