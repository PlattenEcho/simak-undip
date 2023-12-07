<?php

namespace App\Http\Controllers;

use App\Exports\GeneratedAccountExport;
use App\Imports\MahasiswaImport;
use App\Models\Doswal;
use App\Models\GeneratedAccount;
use App\Models\IRS;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
        $mahasiswa = Mahasiswa::where('iduser', $user->id)->first();
        return view('mahasiswa.profile', ["mahasiswa" => $mahasiswa]);
    }

    public function viewEditProfile()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('iduser', $user->id)->first();

        return view('mahasiswa.edit_profile', ["mahasiswa" => $mahasiswa]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim|max:14',
            'nama' => 'required|max:255',
            'angkatan' => 'required|integer|max:9999',
            'jalur_masuk' => 'in:SBUB,SNMPTN,SBMPTN,Mandiri',
            'doswal' => 'required',
        ]);

        if ($request->submit === 'generate') {
            DB::beginTransaction(); 
        
            try {
                $username = Str::slug($request->nama, ''); 
                $username .= Str::random(4);
                $password = Str::random(10);

                $user = User::create([
                    'name' => $request->nama,
                    'username' => $username,
                    'password' => Hash::make($password),
                    'idrole' => 4,
                ]);
            
                $mahasiswa = new Mahasiswa();
                $mahasiswa->nim = $request->nim;
                $mahasiswa->nama = $request->nama;
                $mahasiswa->angkatan = $request->angkatan;
                $mahasiswa->status = "Aktif";
                $mahasiswa->jalur_masuk = $request->jalur_masuk;
                $mahasiswa->nip = $request->doswal;
                $mahasiswa->username = $username;
                $mahasiswa->iduser = $user->id;
                
                $mahasiswa->save();

                GeneratedAccount::create([
                    'nama' => $mahasiswa->nama,
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

    public function generateAccounts()
    {
        try {
            $allMahasiswa = Mahasiswa::whereNull('iduser')->get();

            foreach ($allMahasiswa as $mahasiswa) {
                $username = Str::slug($mahasiswa->nama, '') . Str::random(4);
                $password = Str::random(10);

                $user = User::create([
                    'name' => $mahasiswa->nama,
                    'username' => $username,
                    'password' => Hash::make($password),
                    'idrole' => 4,
                ]);

                $mahasiswa->username = $username;
                $mahasiswa->iduser = $user->id;
                $mahasiswa->save();

                GeneratedAccount::create([
                    'nama' => $mahasiswa->nama,
                    'username' => $username,
                    'password' => $password,
                ]);
            }
            return redirect()->route('mahasiswa.viewAccount')->with('success', 'Akun berhasil dibuat untuk semua mahasiswa.');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.viewGenerateAkun')->with('error', 'Terjadi kesalahan saat membuat akun untuk mahasiswa.');
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $mahasiswa = Mahasiswa::where('iduser', $user->id)->first();

            $validated = $request->validate([
                'nomor_telepon' => 'required|numeric',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'username' => 'required|unique:users,username,' . $user->id,
                'foto' => 'nullable|image|max:10240',
            ]);
        
            if ($request->has('foto')) {
                $fotoPath = $request->file('foto')->store('profile', 'public');
                $validated['foto'] = $fotoPath;

                $user->update([
                    'foto' => $validated['foto'],
                ]);
            }
            
            $mahasiswa->username = $request->username;
            $mahasiswa->nomor_telepon = $request->nomor_telepon;
            $mahasiswa->alamat = $request->alamat;
            $mahasiswa->provinsi = $request->provinsi;
            $mahasiswa->kabupaten = $request->kabupaten;
            
            $mahasiswa->save();

            $user->update([
                'username' => $request->username,
                'profile_completed' => 1
            ]);
            
            return redirect()->route('mahasiswa.viewProfile')->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.viewProfile')->with('error', 'Terjadi kesalahan saat memperbarui data mahasiswa.');
        }
    }

    public function index()
    {
        
  
        return view('operator.import_mhs');
    }

    public function viewAccount()
    {
        $accounts = DB::table('generated_accounts')
        ->join('users', 'generated_accounts.username', '=', 'users.username')
        ->where('users.profile_completed', '=', 0)
        ->select('generated_accounts.*')
        ->get();
  
        return view('operator.daftar_akun', ["accounts" => $accounts]);
    }

    public function viewGenerateAkun()
    {
        $mhsData = Mahasiswa::whereNull('iduser')->get();
  
        return view('operator.generate_akun', ["mhsData" => $mhsData]);
    }

    public function import()
{
    try {
        Excel::import(new MahasiswaImport, request()->file('file'));
        return back()->with('success', 'Impor berhasil');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage());
    }
}

    public function export() 
    {
        return Excel::download(new GeneratedAccountExport, 'akun.xlsx');
    }

    public function viewChangePassword()
    {
        return view('mahasiswa.change_password');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'password_lama' => 'nullable|string',
            'password_baru' => 'nullable|string|min:8',
            'konfirm_password' => 'nullable|string|min:8|same:password_baru'
        ]);

        if ($validated['password_baru'] !== null) {
            if (!Hash::check($validated['password_lama'], $user->password)) {
                return redirect()->route('account.viewChangePassword')->with('error', 'Password lama tidak cocok.');
            }
        }

        DB::beginTransaction();

        try {
            if ($validated['password_baru'] !== null && $validated['konfirm_password'] !== null) {
                $user->update([
                    'password' => Hash::make($validated['password_baru'])
                ]);
            }

            DB::commit();

            return redirect()->route('mahasiswa.viewChangePassword')->with('success', 'Password berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mahasiswa.viewChangePassword')->with('error', 'Gagal memperbarui password.');
        }
    }
}