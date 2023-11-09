<?php

namespace App\Charts;

use App\Models\Skripsi;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use DB;

class CountMahasiswaSkripsiForDepartement
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $pklPerStatus = Skripsi::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $pklData = $pklPerStatus->pluck('count')->toArray();
        $pklLabels = $pklPerStatus->pluck('status')->toArray();

        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', $pklData)
            ->setXAxis($pklLabels)
            ->setColors(['#ffc63b', '#ff6384'])
            ->setWidth(500) // Lebar grafik dalam piksel
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat');
    }
}
