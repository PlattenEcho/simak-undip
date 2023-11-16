<?php

namespace App\Charts;

use App\Models\Skripsi;
use App\Models\Mahasiswa;
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
        $nimSudahSkripsi = Skripsi::pluck('nim')->toArray();

        // Hitung jumlah mahasiswa yang sudah dan belum dalam tabel mahasiswa (misalnya)
        $jumlahSudahSkripsi = Mahasiswa::whereIn('nim', $nimSudahSkripsi)->count();
        $jumlahBelumSkripsi = Mahasiswa::whereNotIn('nim', $nimSudahSkripsi)->count();

        // Bangun grafik
        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', [$jumlahSudahSkripsi, $jumlahBelumSkripsi])
            ->setXAxis(['Sudah', 'Belum'])
            ->setColors(['#ffc63b', '#ff6384'])
            ->setWidth(500) // Lebar grafik dalam piksel
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat');
    }
}
