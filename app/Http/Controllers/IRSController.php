<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
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

        $mhs = Mahasiswa::where('nama', $irs->nama_mhs)->first();

        $semesters = IRS::where('nama_mhs', $mhs->nama)->where('status', '1')->pluck('semester')->toArray();

        $availableSemesters = range(1, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('doswal.edit_irs', ['irs' => $irs, 'remainingSemesters' => $remainingSemesters]);
    }

    public function viewEditIRS2(int $id)
    {
        $irs = IRS::where('id_irs', $id)->first();

        $semesters = IRS::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(1, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);
    
            return view('mahasiswa.edit_irs', ['irs' => $irs, 'remainingSemesters' => $remainingSemesters]);
    
    }

    public function viewEntryIRS(Request $request)
    {   
        // $semesters = IRS::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        // $availableSemesters = range(1, 14);

        // $remainingSemesters = array_diff($availableSemesters, $semesters);

        $semesters = IRS::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        if (empty($semesters)) {
            $nextSemester = 1;
        } else {
            $maxSemester = max($semesters);
            $nextSemester = $maxSemester + 1;
        }

        return view('mahasiswa.entry_irs', ['nextSemester' => $nextSemester]);
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
            if ($request->has('scan_irs')) {
                $irsPath = $request->file('scan_irs')->store('scan_irs', 'public');
                $validated['scan_irs'] = $irsPath;
            }

            IRS::create([
            'nim' => $mahasiswa->nim, 
            'semester' => $request->semester,
            'jml_sks' => $request->jml_sks,
            'scan_irs' => $validated['scan_irs'],
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
        $validated = $request->validate([
            'semester' => 'required',
            'jml_sks' => 'required|numeric',
        ]);
        
        try {
            $irs = IRS::where('id_irs', $id)
            ->first();
            
            $irs->semester = $request->semester;
            $irs->jml_sks = $request->jml_sks;

            $irs->save();
            
        } catch (\Exception $e) {
            $errorMessage = 'Gagal memperbarui data IRS.';
        }
    
        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success',  'Data IRS berhasil diperbarui.');
        }
    
        return redirect()->route('doswal.viewVerifikasiIRS');
    }

    public function update2(Request $request, int $id)
    {
        $validated = $request->validate([
            'semester' => 'required',
            'jml_sks' => 'required|numeric',
        ]);
        
        try {
            $irs = IRS::where('id_irs', $id)
            ->first();
            
            $irs->semester = $request->semester;
            $irs->jml_sks = $request->jml_sks;

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

    public function verifikasi(int $id)
    {
        try {
            $irs = IRS::where('id_irs', $id)->first();

            $irs->update([
                "status" => '1'
            ]);

            return redirect()->back()->with('success', 'Berhasil memverifikasi IRS.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal memverifikasi IRS.');
        }
    }

    public function delete(int $id)
    {
        try {
            $irs = IRS::where('id_irs', $id)->first();
            
            $irs->delete();

            return redirect()->back()->with('success', 'Berhasil menghapus IRS.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus IRS.');
        }
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $semester = $request->input('filter');

        if ($semester == 'all') {
            $irsData = IRS::with('mahasiswa')
            ->where('nama_doswal',$doswal->nama)
            ->where('status', '0')
            ->get();
        } else {
            $irsData = IRS::with('mahasiswa')
            ->where('nama_doswal',$doswal->nama)
            ->where('semester', $semester)
            ->where('status', '0')
            ->get();
        }
        
        $semesters = IRS::where('status', '0')
                        ->where('nama_doswal',$doswal->nama)
                        ->distinct()
                        ->pluck('semester')
                        ->toArray();

        return view('doswal.verifikasi_irs', ['semesters' => $semesters, 'irsData' => $irsData]);
    } 
}
