<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\PKL;
use App\Models\KHS;
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
    
            return view('doswal.edit_pkl', ['pkl' => $pkl, 'remainingSemesters' => $remainingSemesters]);
        
    }
    
    public function viewEditPKL2(int $id)
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
        $khs = KHS::where('nim', $mahasiswa->nim)->where('status', '1')->orderBy('semester', 'desc')->first();
        $existingPKL = PKL::where('nim', $mahasiswa->nim)->first();
// dd($khs);
        if ($existingPKL) {
            $errorMessage = 'Anda sudah memiliki progres PKL.';
            Session::flash('error', $errorMessage);

            return redirect()->route('pkl.viewPKL');
        }

        // SKS Kumulatif minimal 100 sks supaya bisa entry progres PKL
        if ($khs) {
            $sksKumulatif = $khs -> sks_kum;

            if ($sksKumulatif >= 100) {
                $semesters = PKL::where('nim', auth()->user()->name)->pluck('semester')->toArray();
        
                $availableSemesters = range(6, 14);
        
                $remainingSemesters = array_diff($availableSemesters, $semesters);
        
                return view('mahasiswa.entry_pkl', ['remainingSemesters' => $remainingSemesters]);
            } 
        } else {
            $errorMessage = 'Anda belum mencapai sks kumulatif minimal 100 sks untuk mengisi progres PKL.';
            Session::flash('error', $errorMessage);
    
            return redirect()->route('pkl.viewPKL');
        }

    }


    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|numeric|between:6,14',
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
                'status' => $request->status='Lulus',
                'nilai' => $request->nilai,
                'scan_pkl' => $validated['scan_pkl'], 
                'nama_doswal' => $mahasiswa->dosen_wali->nama,
                'nama_mhs' => $mahasiswa->nama,
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
            'semester' => 'required',
            'nilai' => 'required',
        ]);
        
        try {
            $pkl = PKL::where('idPKL', $id)->first();

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
            Session::flash('success', 'Data PKL berhasil diperbarui.');
        }

        return redirect()->route('doswal.viewVerifikasiPKL');
    }

    public function update2(Request $request, int $id)
    {
        $validated = $request->validate([
            'semester' => 'required',
            'nilai' => 'required',
        ]);
        
        try {
            $pkl = PKL::where('idPKL', $id)->first();

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
            Session::flash('success', 'Data PKL berhasil diperbarui.');
        }

        return redirect()->route('pkl.viewPKL');
    }

    public function verifikasi(int $id)
    {
        try {
            $pkl = PKL::where('idPKL', $id)->first();

            $pkl->update([
                "statusVerif" => '1'
            ]);

            return redirect()->back()->with('success', 'Berhasil memverifikasi PKL.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal memverifikasi PKL.');
        }
    }

    public function delete(int $id)
    {
        try {
            $pkl = PKL::where('idPKL', $id)->first();
    
            // Hanya bisa menghapus jika status belum diverifikasi (0)
            if ($pkl->statusVerif == '0') {
                $pkl->delete();
                return redirect()->back()->with('success', 'Berhasil menghapus progres PKL.');
            } else {
                return redirect()->back()->with('error', 'Gagal menghapus progres PKL yang sudah diverifikasi.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus progres PKL.');
        }
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $semester = $request->input('filter');

        if ($semester == 'all') {
            $pklData = PKL::with('mahasiswa')
            ->where('nama_doswal',$doswal->nama)
            ->where('statusVerif', '0')
            ->get();
        } else {
            $pklData = PKL::with('mahasiswa')
            ->where('nama_doswal',$doswal->nama)
            ->where('semester', $semester)
            ->where('statusVerif', '0')
            ->get();
        }
        
        $semesters = PKL::where('statusVerif', '0')
                        ->where('nama_doswal',$doswal->nama)
                        ->distinct()
                        ->pluck('semester')
                        ->toArray();

        return view('doswal.verifikasi_pkl', ['semesters' => $semesters, 'pklData' => $pklData]);
    } 
}
