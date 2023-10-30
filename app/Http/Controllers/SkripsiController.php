<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Auth;
use Illuminate\Http\Request;

class SkripsiController extends Controller
{
    public function viewSkripsi()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('username', $user->username)->first();
        $skripsiData = $mahasiswa->skripsi;

        return view('mahasiswa.skripsi', ['skripsiData' => $skripsiData]);
    }
}
