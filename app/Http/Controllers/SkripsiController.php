<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\PKL;
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
