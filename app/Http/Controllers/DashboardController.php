<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function viewDashboardOperator()
    {
        return view("operator.dashboard");
    }

    public function viewDashboardMahasiswa()
    {
        return view("mahasiswa.dashboard");
    }
}
