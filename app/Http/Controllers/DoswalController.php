<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class DoswalController extends Controller
{
    public function searchMahasiswa(Request $request)
    {
    $search = $request->input('search');

    if (!empty($search)) {
        $mhsData = Mahasiswa::where(function($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%');
        })->get();
    } 

    return view('doswal.daftar_mhs', ['mhsData' => $mhsData]);
    }   
}
