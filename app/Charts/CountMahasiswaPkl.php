<?php

namespace App\Charts;

use App\Models\Doswal;
use App\Models\Mahasiswa;
use App\Models\PKL;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

//use DB;

class CountMahasiswaPkl
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $userID = auth()->user()->id;
        $dosenWali = Doswal::where('iduser', $userID)->first();
        $mahasiswaPerwalian = $dosenWali->mahasiswa;

        $pklMahasiswaPerwalian = PKL::whereIn('nim', $mahasiswaPerwalian->pluck('nim'))
            ->where('statusVerif', '1')
            ->pluck('nim')
            ->toArray();

        $jumlahSudahPKL = count(array_unique($pklMahasiswaPerwalian));
        $jumlahBelumPKL = count($mahasiswaPerwalian) - $jumlahSudahPKL;

        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', [$jumlahSudahPKL, $jumlahBelumPKL])
            ->setXAxis(['Sudah', 'Belum'])
            ->setColors(['#00ff00', '#ff0000'])
            ->setWidth(325) // Lebar grafik dalam piksel
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat');
    }
}
