<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkripsiController extends Controller
{
    public function viewSkripsi()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();
        $skripsiData = $mahasiswa->skripsi;
        return view('mahasiswa.skripsi', ['skripsiData' => $skripsiData]);
    }

    public function viewEntrySkripsi()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();
        $existingSkripsi = Skripsi::where('nim', $mahasiswa->nim)->first();

        if ($existingSkripsi) {
            $errorMessage = 'Anda sudah memiliki progres Skripsi.';
            Session::flash('error', $errorMessage);
            return redirect()->route('pkl.viewPKL');
        }

        $semesters = Skripsi::where('nim', auth()->user()->name)->pluck('semester')->toArray();
        $availableSemesters = range(7, 14);
        $remainingSemesters = array_diff($availableSemesters, $semesters);
        return view('mahasiswa.entry_skripsi', ['remainingSemesters' => $remainingSemesters]);
    }

    public function viewEditSkripsi(int $id)
    {
        $skripsi = Skripsi::where('id_skripsi', $id)->first();

        $semesters = Skripsi::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(6, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('doswal.edit_skripsi', ['skripsi' => $skripsi, 'remainingSemesters' => $remainingSemesters]);
    }

    public function viewEditSkripsiM(int $id)
    {
        $skripsi = Skripsi::where('id_skripsi', $id)->first();
        $semesters = Skripsi::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();
        $availableSemesters = range(6, 14);
        $remainingSemesters = array_diff($availableSemesters, $semesters);
        return view('mahasiswa.edit_skripsi', ['skripsi' => $skripsi, 'remainingSemesters' => $remainingSemesters]);
    }

    public function viewDeleteSkripsiM(int $id)
    {
        $skripsi = Skripsi::where('id_skripsi', $id)->first();
        $semesters = Skripsi::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();
        $availableSemesters = range(6, 14);
        $remainingSemesters = array_diff($availableSemesters, $semesters);
        return view('mahasiswa.delete_skripsi', ['skripsi' => $skripsi, 'remainingSemesters' => $remainingSemesters]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'semester' => 'required|numeric|between:6,14',
            'lama_studi' => 'required',
            'tanggal_sidang' => 'required',
            // 'status' => 'required',
            'nilai' => 'required',
            'scan_skripsi' => 'required|max:5120',
        ]);


        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();

        try {

            if ($request->has('scan_skripsi')) {
                $skripsiPath = $request->file('scan_skripsi')->store('scan_skripsi', 'public');
                $validated['scan_skripsi'] = $skripsiPath;
            }

            $skripsi = Skripsi::create([
                'semester' => $request->semester,
                'lama_studi' => $request->lama_studi,
                'tanggal_sidang' => $request->tanggal_sidang,
                'nim' => $mahasiswa->nim,
                'scan_skripsi' => $validated['scan_skripsi'],
                'status' => 'Lulus',
                'nilai' => $request->nilai,
                'nama_doswal' => $mahasiswa->dosen_wali->nama,
                'nama_mhs' => $mahasiswa->nama,
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
            $errorMessage = 'Gagal menyimpan data Skripsi.';
        }

        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success', 'Data Skripsi berhasil disimpan.');
        }

        return redirect()->route('skripsi.viewSkripsi');
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'semester' => 'required|numeric|between:7,14',
            'lama_studi' => 'required',
            'tanggal_sidang' => 'required',
            'nilai' => 'required',
        ]);

        try {
            $skripsi = Skripsi::where('id_skripsi', $id)->first();

            $skripsi->semester = $request->semester;
            $skripsi->nilai = $request->nilai;
            $skripsi->lama_studi = $request->lama_studi;
            $skripsi->tanggal_sidang = $request->tanggal_sidang;

            $skripsi->save();

        } catch (\Exception $e) {
            $errorMessage = 'Gagal memperbarui data skripsi.';
        }

        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success', 'Data skripsi berhasil diperbarui.');
        }

        if (auth()->user()->idrole == 3) {
            return redirect()->route('doswal.viewVerifikasiSkripsi');
        }
        if (auth()->user()->idrole == 4) {
            return redirect()->route('skripsi.viewSkripsi');
        }
    }

    public function deleteM(int $id)
    {
        try {
            $pkl = Skripsi::where('id_skripsi', $id)->first();
            $pkl->delete();
            Session::flash('success', 'Berhasil menghapus skripsi.');
            return redirect()->route('skripsi.viewSkripsi');
        } catch (\Exception $e) {
            Session::flash('success', 'Data skripsi berhasil diperbarui.');
        }
    }

    public function verifikasi(int $id)
    {
        try {
            $skripsi = Skripsi::where('id_skripsi', $id)->first();

            $skripsi->update([
                "statusVerif" => '1'
            ]);

            return redirect()->back()->with('success', 'Berhasil memverifikasi skripsi.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal memverifikasi skripsi.');
        }
    }


    public function delete(int $id)
    {
        try {
            $pkl = Skripsi::where('id_skripsi', $id)->first();

            $pkl->delete();

            return redirect()->back()->with('success', 'Berhasil menghapus skripsi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus skripsi.');
        }
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $semester = $request->input('filter');

        if ($semester == 'all') {
            $skripsiData = Skripsi::with('mahasiswa')
                ->where('nama_doswal', $doswal->nama)
                ->where('statusVerif', '0')
                ->get();
        } else {
            $skripsiData = Skripsi::with('mahasiswa')
                ->where('nama_doswal', $doswal->nama)
                ->where('semester', $semester)
                ->where('statusVerif', '0')
                ->get();
        }

        $semesters = Skripsi::where('statusVerif', '0')
            ->where('nama_doswal', $doswal->nama)
            ->distinct()
            ->pluck('semester')
            ->toArray();

        return view('doswal.verifikasi_skripsi', ['semesters' => $semesters, 'skripsiData' => $skripsiData]);
    }
}
