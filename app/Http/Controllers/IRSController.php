<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IRSController extends Controller
{
    public function viewIRS()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();
        $irsData = $mahasiswa->irs;

        return view('mahasiswa.irs', ['irsData' => $irsData]);
    }

    public function viewEditIRS(int $id)
    {
        $irs = IRS::where('id_irs', $id)
        ->first();

        $semesters = IRS::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(1, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('mahasiswa.edit_irs', ['irs' => $irs, 'remainingSemesters' => $remainingSemesters]);
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

    public function update(Request $request, int $id)
    {
        $request->validate([
            'semester' => 'required',
            'jml_sks' => 'required|numeric',
            'scan_irs' => 'required|max:5120',
        ]);
        
        try {
            $irs = IRS::where('id_irs', $id)
            ->first();
            
            $irs->semester = $request->semester;
            $irs->jml_sks = $request->jml_sks;
            $irs->scan_irs = $request->scan_irs;
            $irs->status = "Unverified";

            $irs->save();
        } catch (\Exception $e) {
            $errorMessage = 'Gagal memperbarui data IRS.';
        }
    
        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success',  'Data IRS berhasil diperbarui.');
        }
    
        return redirect()->route('irs.viewIRS');
    }
}
