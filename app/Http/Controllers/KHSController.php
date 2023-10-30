<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class KHSController extends Controller
{
    public function viewKHS()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();
        $khsData = $mahasiswa->khs;

        return view('mahasiswa.khs', ['khsData' => $khsData]);
    }

    public function viewEditKHS(int $id)
    {
        $khs = KHS::where('id_khs', $id)
        ->first();

        $semesters = KHS::where('namaMhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(1, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('mahasiswa.edit_khs', ['khs' => $khs, 'remainingSemesters' => $remainingSemesters]);
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
    try {
        $request->validate([
            'semester' => 'required',
            'sks_smt' => 'required|numeric',
            'sks_kum' => 'required|numeric',
            'ips' => 'required|regex:/^\d+(\.\d{0,2})?$/',
            'ipk' => 'required|regex:/^\d+(\.\d{0,2})?$/',
            'scan_khs' => 'required|max:100', 
        ]);
        

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();

        KHS::create([
            'nim' => $mahasiswa->nim,
            'semester' => $request->semester,
            'sks_smt' => $request->sks_smt,
            'sks_kum' => $request->sks_kum,
            'ips' => $request->ips,
            'ipk' => $request->ipk,
            'scan_khs' => $request->scan_khs,
            'nama_mhs' => $mahasiswa->nama,
            'nama_doswal' => $mahasiswa->dosen_wali->nama,
        ]);

        Session::flash('success', 'Data KHS berhasil disimpan.');
    } catch (\Exception $e) {
        Session::flash('error', 'Gagal menyimpan data KHS.');
    }

    return redirect()->route('khs.viewKHS');
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'semester' => 'required',
            'sks_smt' => 'required|numeric',
            'sks_kum' => 'required|numeric',
            'ips' => 'required|regex:/^\d+(\.\d{0,2})?$/',
            'ipk' => 'required|regex:/^\d+(\.\d{0,2})?$/',
            'scan_khs' => 'required|max:100', 
        ]);
        
        try {
            $khs = KHS::where('id_khs', $id)
            ->first();

            if ($request->has('scan_khs')) {
                $khsPath = $request->file('scan_khs')->store('scan_khs', 'public');
                $validated['scan_khs'] = $khsPath;

                $khs->scan_khs = $validated['scan_khs'];
            }
            
            $khs->semester = $request->semester;
            $khs->sks_smt = $request->sks_smt;
            $khs->sks_kum = $request->sks_kum;
            $khs->ips = $request->ips;
            $khs->ipk = $request->ipk;
            $khs->status = "Unverified";

            $khs->save();
            
        } catch (\Exception $e) {
            $errorMessage = 'Gagal memperbarui data KHS.';
        }
    
        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success',  'Data KHS berhasil diperbarui.');
        }
    
        return redirect()->route('khs.viewKHS');
    }

}
