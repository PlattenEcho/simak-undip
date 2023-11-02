<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Skripsi;
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

    public function viewEditSkripsi(int $id)
    {
        $pkl = Skripsi::where('idPKL', $id)->first();

        $semesters = Skripsi::where('nama_mhs', auth()->user()->name)->pluck('semester')->toArray();

        $availableSemesters = range(7, 14);

        $remainingSemesters = array_diff($availableSemesters, $semesters);

        return view('mahasiswa.edit_pkl', ['pkl' => $pkl, 'remainingSemesters' => $remainingSemesters]);
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
