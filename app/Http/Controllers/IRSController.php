<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;

class IRSController extends Controller
{
    public function viewIRS()
    {
        return view('mahasiswa.irs');
    }

    public function viewEntryIRS()
    {
        return view('mahasiswa.entry_irs', compact('matkul_genap', 'matkul_ganjil'));
    }

}
