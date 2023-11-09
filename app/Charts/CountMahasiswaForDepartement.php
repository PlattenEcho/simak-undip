<?php

namespace App\Charts;

use App\Models\Mahasiswa;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use DB;

class CountMahasiswaForDepartement
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
        $colors = [
            '#008FFB',
            '#00E396',
            '#feb019',
            '#ff455f',
            '#775dd0',
            '#80effe',
            '#0077B5',
            '#ff6384',
            '#c9cbcf',
            '#0057ff',
            '#00a9f4',
            '#2ccdc9',
            '#5e72e4'
        ]; // Array warna yang berbeda untuk setiap bar

        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', $jumlahMahasiswa)
            ->setXAxis($angkatanLabels)
            ->setColors($colors) // Mengatur warna untuk setiap bar
            ->setWidth(1100) // Mengatur lebar grafik menjadi 100% dari container
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat')
            ->setColors([$colors[0], $colors[1], $colors[2], $colors[3], $colors[4]]);
    }
}
