<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
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

    public function viewDaftarMhs()
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();
        $mhsData = $doswal->mahasiswa;

        return view('doswal.daftar_mhs', ['mhsData' => $mhsData]);
    }

    public function viewInfoAkademik(string $nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $foto = User::where('id',$mahasiswa->iduser)->first()->getImageURL();
        $allSemester = range(1, 14);
        $semester = request()->query('semester'); // Mengambil nilai semester dari query parameter

        $irs = $mahasiswa->irs()
            ->where('semester', $semester)
            ->first();

        $khs = $mahasiswa->khs()
            ->where('semester', $semester)
            ->first();

        $pkl = $mahasiswa->pkl()
            ->where('nim', $nim)
            ->first();

        $skripsi = $mahasiswa->skripsi()
            ->where('nim', $nim)
            ->first();
        
        return view('doswal.info_akademik', ['mahasiswa' => $mahasiswa, 'foto' => $foto, 'allSemester' => $allSemester, 
                    'irs' => $irs, 'khs' => $khs, 'pkl' => $pkl, 'skripsi' => $skripsi]);
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
                $mahasiswa->status = $request->status;
                $mahasiswa->jalur_masuk = $request->jalur_masuk;
                $mahasiswa->nip = $request->doswal;
                $mahasiswa->username = $username;
                $mahasiswa->iduser = $user->id;
                
                $mahasiswa->save();

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

    public function uploadExcelForm()
    {
        return view('operator.upload_excel');
    }

    public function uploadExcel(Request $request)
    {
        $file = $request->file('excel_file');

        // Validasi file Excel
        $this->validate($request, [
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        // Baca data dari file Excel
        $data = Excel::toArray([], $file);
        
        // Proses data dan masukkan ke dalam database
        foreach ($data[0] as $row) {
            Mahasiswa::create([
                'nim' => $row[0],
                'nama' => $row[1],
                'angkatan' => $row[2],
                'status' => $row[3],
                'jalur_masuk' => $row[4],
                'nip' => $row[5],
            ]);


            // Generate akun mahasiswa dan kirim informasi login (jika diperlukan)
        }

        return redirect()->back()->with('success', 'Data mahasiswa berhasil diunggah.');
    }
}