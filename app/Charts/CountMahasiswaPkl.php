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
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $pklData = $pklMahasiswaPerwalian->pluck('count')->toArray();
        $pklLabels = $pklMahasiswaPerwalian->pluck('status')->toArray();

        $pklColors = [];
        foreach ($pklLabels as $label) {
            if ($label === 'Lulus') {
                $pklColors[] = '#00ff00'; // Warna hijau untuk status Lulus
            } elseif ($label === 'Tidak Lulus') {
                $pklColors[] = '#ff0000'; // Warna merah untuk status Tidak Lulus
            } else {
                $pklColors[] = '#000000'; // Warna default untuk status lainnya
            }
        }

        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', $pklData)
            ->setXAxis($pklLabels)
            ->setColors(['#ffc63b', '#ff6384'])
            ->setWidth(325) // Lebar grafik dalam piksel
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat');
    }
}
