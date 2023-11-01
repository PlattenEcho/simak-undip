<?php

namespace App\Http\Controllers;

use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PKLController extends Controller
{
    public function viewPKL()
    {
    $user = Auth::user();
    $mahasiswa = Mahasiswa::where('username', $user->username)->first();
    $pklData = $mahasiswa->pkl;

    return view('mahasiswa.pkl', ['pklData' => $pklData]);
    }

    public function viewEditPKL(int $id)
    {
        $pkl = PKL::where('idPKL', $id)->first();

        $semesters = PKL::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(6, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('mahasiswa.edit_pkl', ['pkl' => $pkl, 'remainingSemesters' => $remainingSemesters]);
    }

    public function viewEntryPKL()
{
    $user = Auth::user();
    $mahasiswa = Mahasiswa::where('username', $user->username)->first();
    $existingPKL = PKL::where('nim', $mahasiswa->nim)->first();

    if ($existingPKL) {
        $errorMessage = 'Anda sudah memiliki progres PKL.';
        Session::flash('error', $errorMessage);

        return redirect()->route('pkl.viewPKL');
    }

    $semesters = PKL::where('nim', auth()->user()->name)->pluck('semester')->toArray();

    $availableSemesters = range(6, 14);

    $remainingSemesters = array_diff($availableSemesters, $semesters);

    return view('mahasiswa.entry_pkl', ['remainingSemesters' => $remainingSemesters]);
}


    public function store(Request $request)
{
    $request->validate([
        'semester' => 'required|numeric|between:6,14',
        'status' => 'required',
        'nilai' => 'required',
        'scan_pkl' => 'required|max:5120',
    ]);
    

    $user = Auth::user();
    $mahasiswa = Mahasiswa::where('username', $user->username)->first();

    $validated = []; 

    try {
        if ($request->has('scan_pkl')) {
            $pklPath = $request->file('scan_pkl')->store('scan_pkl', 'public');
            $validated['scan_pkl'] = $pklPath; 
        }

        PKL::create([
            'semester' => $request->semester,
            'nim' => $mahasiswa->nim,
            'status' => $request->status,
            'nilai' => $request->nilai,
            'scan_pkl' => $validated['scan_pkl'], 
        ]);

    } catch (\Exception $e) {
        $errorMessage = 'Gagal menyimpan data PKL.';
    }

    if (!empty($errorMessage)) {
        Session::flash('error', $errorMessage);
    } else {
        Session::flash('success',  'Data PKL berhasil disimpan.');
    }

    return redirect()->route('pkl.viewPKL');
}


    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'semeter' => 'required',
            'status' => 'required',
            'nilai' => 'required',
            'scan_pkl' => 'nullable|max:5120',
        ]);

        try {
            $pkl = PKL::where('idPKL', $id)->first();

            if ($request->has('scan_pkl')) {
                $pklPath = $request->file('scan_pkl')->store('scan_pkl', 'public');
                $validated['scan_pkl'] = $pklPath;

                $pkl->scan_pkl = $validated['scan_pkl'];
            }
            
            $pkl->semester = $request->semester;
            $pkl->status = $request->status;
            $pkl->nilai = $request->nilai;

            $pkl->save();

        } catch (\Exception $e) {
            $errorMessage = 'Gagal memperbarui data PKL.';
        }

        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success',  'Data PKL berhasil diperbarui.');
        }

        return redirect()->route('pkl.viewPKL');
    }

    public function verifikasi(int $id)
    {
        try {
            $pkl = PKL::where('idPKL', $id)->first();

            $pkl->update([
                "statusVerif" => 'Approved'
            ]);

            return redirect()->back()->with('success', 'Berhasil memverifikasi PKL.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal memverifikasi PKL.');
        }
    }


    public function reject(int $id)
    {
        try {
            $pkl = PKL::where('idPKL', $id)->first();
            
            $pkl->update([
                "statusVerif" => 'Rejected'
            ]);

            return redirect()->back()->with('success', 'PKL berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak PKL.');
        }
    }
}
