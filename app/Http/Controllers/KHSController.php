<?php

namespace App\Http\Controllers;

use App\Models\Doswal;
use App\Models\IRS;
use App\Models\KHS;
use Illuminate\Support\Facades\DB;
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

        $semesters = KHS::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(1, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('doswal.edit_khs', ['khs' => $khs, 'remainingSemesters' => $remainingSemesters]);
    }

    public function viewEditKHS2(int $id)
    {
        $khs = KHS::where('id_khs', $id)
            ->first();

        $semesters = KHS::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(1, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('mahasiswa.edit_khs', ['khs' => $khs, 'remainingSemesters' => $remainingSemesters]);
    }

    public function viewEntryKHS(Request $request)
    {
        $semestersKHS = KHS::where(
            'nama_mhs',
            auth()->user()->name
        )->pluck('semester')->toArray();

        // Ambil semester untuk IRS dengan status 1
        $semestersIRS = DB::table('irs')
            ->select("semester")
            ->where('nama_mhs', auth()->user()->name)
            ->where("status", '1')
            ->pluck('semester')
            ->toArray();

        // Tentukan semester berikutnya untuk IRS
        if (empty($semestersIRS)) {
            $maxSemesterIRS = 0;
        } else {
            $maxSemesterIRS = max($semestersIRS);
        }

        if (empty($semestersKHS)) {
            $nextSemesterKHS = 1;
        } else {
            $maxSemesterKHS = max($semestersKHS);
            $nextSemesterKHS = $maxSemesterKHS + 1;
        }

        // Tambahkan kondisi bahwa IRS harus diisi terlebih dahulu sebelum mengisi KHS
        if ($maxSemesterIRS == $nextSemesterKHS) {
            return view('mahasiswa.entry_khs', ['nextSemester' => $nextSemesterKHS]);
        } else {
            return redirect()->route('khs.viewKHS')
                ->with('error', 'Anda harus mengisi IRS terlebih dahulu sebelum mengisi KHS.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'sks_smt' => 'required|numeric',
            'sks_kum' => 'required|numeric',
            'ips' => 'required|regex:/^\d+(\.\d{0,2})?$/',
            'ipk' => 'required|regex:/^\d+(\.\d{0,2})?$/',
            'scan_khs' => 'required|max:5120',
        ]);

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();
        try {
            if ($request->has('scan_khs')) {
                $khsPath = $request->file('scan_khs')->store('scan_khs', 'public');
                $validated['scan_khs'] = $khsPath;
            }

            KHS::create([
                'nim' => $mahasiswa->nim,
                'semester' => $request->semester,
                'sks_smt' => $request->sks_smt,
                'sks_kum' => $request->sks_kum,
                'ips' => $request->ips,
                'ipk' => $request->ipk,
                'scan_khs' => $validated['scan_khs'],
                'nama_mhs' => $mahasiswa->nama,
                'nama_doswal' => $mahasiswa->dosen_wali->nama,
            ]);

            Session::flash('success', 'Data KHS berhasil disimpan.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Session::flash('error', 'Gagal menyimpan data KHS.');
        }

        return redirect()->route('khs.viewKHS');
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'sks_smt' => 'required|numeric',
            'sks_kum' => 'required|numeric',
            'ips' => 'required|regex:/^\d+(\.\d{0,2})?$/',
            'ipk' => 'required|regex:/^\d+(\.\d{0,2})?$/',
        ]);

        try {
            $khs = KHS::where('id_khs', $id)
                ->first();

            $khs->sks_smt = $request->sks_smt;
            $khs->sks_kum = $request->sks_kum;
            $khs->ips = $request->ips;
            $khs->ipk = $request->ipk;
            $khs->status = "0";

            $khs->save();

        } catch (\Exception $e) {
            $errorMessage = 'Gagal memperbarui data KHS.';
        }

        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success', 'Data KHS berhasil diperbarui.');
        }

        return redirect()->route('doswal.viewVerifikasiKHS');
    }

    public function update2(Request $request, int $id)
    {
        $validated = $request->validate([
            'sks_smt' => 'required|numeric',
            'sks_kum' => 'required|numeric',
            'ips' => 'required|regex:/^\d+(\.\d{0,2})?$/',
            'ipk' => 'required|regex:/^\d+(\.\d{0,2})?$/',
        ]);

        try {
            $khs = KHS::where('id_khs', $id)
                ->first();

            $khs->sks_smt = $request->sks_smt;
            $khs->sks_kum = $request->sks_kum;
            $khs->ips = $request->ips;
            $khs->ipk = $request->ipk;
            $khs->status = "0";

            $khs->save();

        } catch (\Exception $e) {
            $errorMessage = 'Gagal memperbarui data KHS.';
        }

        if (!empty($errorMessage)) {
            Session::flash('error', $errorMessage);
        } else {
            Session::flash('success', 'Data KHS berhasil diperbarui.');
        }

        return redirect()->route('khs.viewKHS');
    }

    public function verifikasi(int $id)
    {
        try {
            $khs = KHS::where('id_khs', $id)->first();

            $khs->update([
                "status" => "1"
            ]);

            return redirect()->back()->with('success', 'Berhasil memverifikasi KHS.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal memverifikasi KHS.');
        }
    }

    public function delete(int $id)
    {
        try {
            $khs = KHS::where('id_khs', $id)->first();

            $khs->delete();

            return redirect()->back()->with('success', 'Berhasil menghapus KHS.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus KHS.');
        }
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        $doswal = Doswal::where('iduser', $user->id)->first();

        $semester = $request->input('filter');

        if ($semester == 'all') {
            $khsData = KHS::with('mahasiswa')
                ->where('nama_doswal', $doswal->nama)
                ->where('status', '0')
                ->get();
        } else {
            $khsData = KHS::with('mahasiswa')
                ->where('nama_doswal', $doswal->nama)
                ->where('semester', $semester)
                ->where('status', '0')
                ->get();
        }

        $semesters = KHS::where('status', '0')
            ->where('nama_doswal', $doswal->nama)
            ->distinct()
            ->pluck('semester')
            ->toArray();

        return view('doswal.verifikasi_khs', ['semesters' => $semesters, 'khsData' => $khsData]);
    }

}
