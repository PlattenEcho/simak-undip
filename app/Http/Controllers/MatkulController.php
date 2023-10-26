<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;

class MatkulController extends Controller
{
    public function getMatkulBySemester($semester) {
        $matkul = Matkul::where('semester', $semester)->get();

        return response()->json($matkul);
    }
    
}
