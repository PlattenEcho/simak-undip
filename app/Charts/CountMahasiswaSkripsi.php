<?php

namespace App\Charts;

use App\Models\Doswal;
use App\Models\Skripsi;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use DB;

class CountMahasiswaSkripsi
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

        $skripsiMahasiswaPerwalian = Skripsi::whereIn('nim', $mahasiswaPerwalian->pluck('nim'))
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $skripsiData = $skripsiMahasiswaPerwalian->pluck('count')->toArray();
        ;
        $skripsiLabels = $skripsiMahasiswaPerwalian->pluck('status')->toArray();
        ;

        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', $skripsiData)
            ->setXAxis($skripsiLabels)
            ->setWidth(325) // Lebar grafik dalam piksel
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat');
    }
}
