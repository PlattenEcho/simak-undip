<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function showEntryMhs()
    {
        $dosen_wali = Doswal::all();

        return view('operator.entry_mhs', ['dosen_wali' => $dosen_wali]);
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

    $mahasiswa = new Mahasiswa();
    $mahasiswa->nim = $request->nim;
    $mahasiswa->nama = $request->nama;
    $mahasiswa->angkatan = $request->angkatan;
    $mahasiswa->status = $request->status;
    $mahasiswa->jalur_masuk = $request->jalur_masuk;
    $mahasiswa->email = $request->email;
    $mahasiswa->nip = $request->doswal;

    $mahasiswa->save();

    return redirect()->route('mahasiswa.showEntry')
    ->with('success', 'Data mahasiswa berhasil disimpan.')
    ->withInput();
    }
}
