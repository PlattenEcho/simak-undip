<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        //dd($request->scan_skripsi);
        $validated = $request->validate([
            'semester' => 'required|numeric|between:6,14',
            'lama_studi' => 'required',
            'tanggal_sidang' => 'required',
            'status' => 'required',
            'nilai' => 'required',
            'scan_skripsi' => 'required|max:5120',
        ]);


        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();

        //$validated = [];

        try {

            if ($request->has('scan_skripsi')) {
                $skripsiPath = $request->file('scan_skripsi')->store('scan_skripsi', 'public');
                $validated['scan_skripsi'] = $skripsiPath;
            }
            //dd($validated['scan_skripsi']);

            $skripsi = Skripsi::create([
                'semester' => $request->semester,
                'lama_studi' => $request->lama_studi,
                'tanggal_sidang' => $request->tanggal_sidang,
                'nim' => $mahasiswa->nim,
                'scan_skripsi' => $validated['scan_skripsi'],
                'status' => $request->status,
                'nilai' => $request->nilai,

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

    public function verifikasi(int $id)
    {
        try {
            $skripsi = Skripsi::where('id_skripsi', $id)->first();

            $skripsi->update([
                "statusVerif" => 'Approved'
            ]);

            return redirect()->back()->with('success', 'Berhasil memverifikasi skripsi.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal memverifikasi skripsi.');
        }
    }


    public function reject(int $id)
    {
        try {
            $skripsi = Skripsi::where('id_skripsi', $id)->first();

            $skripsi->update([
                "statusVerif" => 'Rejected'
            ]);

            return redirect()->back()->with('success', 'Skripsi berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak skripsi.');
        }
    }
}
