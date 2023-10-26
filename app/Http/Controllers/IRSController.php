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
        $semester = $request->input('semester');

        $mataKuliah = Matkul::where('semester', ($semester % 2 == 0) ? 'Genap' : 'Ganjil')->get();
        
        return view('mahasiswa.entry_irs', ["semester" => $semester, "mataKuliah" => $mataKuliah]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'matkul' => 'required',
            'scan_irs' => 'required|max:5120',
        ]);
    
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();

        $errorMessage = '';
    
        foreach ($request->matkul as $kode_mk) {
            $matkul = Matkul::where('kode_mk', $kode_mk)->first();
    
            try {
                IRS::create([
                    'nim' => $mahasiswa->nim, 
                    'kode_mk' => $kode_mk,
                    'semester' => $request->semester,
                    'jml_sks' => $matkul->jml_sks,
                    'scan_irs' => $request->scan_irs,
                ]);
            } catch (\Exception $e) {
                $errorMessage = 'Gagal menyimpan data IRS.';
            }
        }
    
        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success',  'Data IRS berhasil disimpan.');
        }
    
        return redirect()->route('irs.viewIRS');
    }
}
