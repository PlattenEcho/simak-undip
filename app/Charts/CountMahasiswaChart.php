<?php

namespace App\Charts;

use App\Models\Mahasiswa;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class CountMahasiswaChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $jumlahMahasiswaPerAngkatan = Mahasiswa::select('angkatan', DB::raw('count(*) as total_mahasiswa'))
            ->groupBy('angkatan')
            ->get();

        $angkatanLabels = $jumlahMahasiswaPerAngkatan->pluck('angkatan')->toArray();
        $jumlahMahasiswa = $jumlahMahasiswaPerAngkatan->pluck('total_mahasiswa')->toArray();

        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', $jumlahMahasiswa)
            ->setXAxis($angkatanLabels)
            ->setWidth(700) // Lebar grafik dalam piksel
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat');
    }
}
