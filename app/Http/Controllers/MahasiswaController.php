<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\GeneratedAccount;
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
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();

        return view('mahasiswa.profile', ["mahasiswa" => $mahasiswa]);
    }

    public function viewEditProfile()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();

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
            'doswal' => 'required',
        ]);

        if ($request->submit === 'generate') {
            DB::beginTransaction(); 
        
            try {
                $username = Str::slug($request->nama, ''); 
                $username .= Str::random(4);

                $mahasiswa = new Mahasiswa();
                $mahasiswa->nim = $request->nim;
                $mahasiswa->nama = $request->nama;
                $mahasiswa->angkatan = $request->angkatan;
                $mahasiswa->status = $request->status;
                $mahasiswa->jalur_masuk = $request->jalur_masuk;
                $mahasiswa->nip = $request->doswal;
                $mahasiswa->username = $username;
                
                $mahasiswa->save();
                $password = Str::random(10);
                
                User::create([
                    'name' => $request->nama,
                    'username' => $username,
                    'password' => Hash::make($password),
                    'idrole' => 4,
                ]);

                GeneratedAccount::create([
                    'username' => $username,
                    'password' => $password,
                ]);
        
                DB::commit(); 
        
                return redirect()->route('mahasiswa.showEntry')
                    ->with('success', 'Data dan akun berhasil ditambahkan. Username: ' . $username . ' dan password: ' . $password)->withInput();
            } catch (\Exception $e) {
                DB::rollback(); 
                return redirect()->route('mahasiswa.showEntry')
                    ->with('error', 'Gagal menambahkan data dan akun.');
            }
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();

        $request->validate([
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
        ]);
      
        //$mahasiswa = Mahasiswa::find($nim);
    
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }
    
        $mahasiswa->nomor_telepon = $request->nomor_telepon;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->provinsi = $request->provinsi;
        $mahasiswa->kabupaten = $request->kabupaten;
        
        $mahasiswa->save();
    
        return redirect()->route('mahasiswa.viewProfile')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }
    
}