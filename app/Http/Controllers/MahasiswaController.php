<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MahasiswaController extends Controller
{
    public function showEntryMhs()
    {
        $dosen_wali = Doswal::all();

        return view('operator.entry_mhs', ['dosen_wali' => $dosen_wali]);
    }

    public function viewProfile()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();

        return view('mahasiswa.profile', ["mahasiswa" => $mahasiswa]);
    }

    public function viewEditProfile()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();

        return view('mahasiswa.edit_profile', ["mahasiswa" => $mahasiswa]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim|max:14',
            'nama' => 'required|max:255',
            'angkatan' => 'required|integer|max:9999',
            'status' => 'in:Aktif,Cuti,Dropout',
            'jalur_masuk' => 'in:SBUB,SNMPTN,SBMPTN,Mandiri',
            'email' => 'max:100|email|unique:mahasiswa,email',
            'doswal' => 'required',
        ]);

        if ($request->submit === 'generate') {
            DB::beginTransaction(); // Memulai transaksi
        
            try {
                $mahasiswa = new Mahasiswa();
                $mahasiswa->nim = $request->nim;
                $mahasiswa->nama = $request->nama;
                $mahasiswa->angkatan = $request->angkatan;
                $mahasiswa->status = $request->status;
                $mahasiswa->jalur_masuk = $request->jalur_masuk;
                $mahasiswa->email = $request->email;
                $mahasiswa->nip = $request->doswal;
        
                $mahasiswa->save();
        
                $password = Str::random(10);
                User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    'idrole' => 4,
                ]);
        
                DB::commit(); 
        
                return redirect()->route('mahasiswa.showEntry')
                    ->with('success', 'Data dan akun berhasil ditambahkan. Email: ' . $request->email . ' dan Password: ' . $password)->withInput();
            } catch (\Exception $e) {
                DB::rollback(); 
                return redirect()->route('mahasiswa.showEntry')
                    ->with('error', 'Gagal menambahkan data dan akun.');
            }
        }
    }

    public function update(Request $request)
    {
        dd($request->alamat);
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();

        $request->validate([
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
        ]);
      
        //$mahasiswa = Mahasiswa::find($nim);
    
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }
    
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->provinsi = $request->provinsi;
        $mahasiswa->kabupaten = $request->kabupaten;
        
        $mahasiswa->save();
    
        return redirect()->route('mahasiswa.viewEditProfile')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }
    
}