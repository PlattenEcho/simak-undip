<?php

namespace App\Charts;

use App\Models\PKL;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Mahasiswa;
use DB;

class CountMahasiswaPklForDepartemen
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $nimSudahPKL = PKL::where('statusVerif', '1')->pluck('nim')->toArray();

        // Hitung jumlah mahasiswa yang sudah dan belum dalam tabel mahasiswa (misalnya)
        $jumlahSudahPKL = Mahasiswa::whereIn('nim', $nimSudahPKL)->count();
        $jumlahBelumPKL = Mahasiswa::whereNotIn('nim', $nimSudahPKL)->count();

        // Bangun grafik
        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', [$jumlahSudahPKL, $jumlahBelumPKL])
            ->setXAxis(['Sudah', 'Belum'])
            ->setColors(['#ffc63b', '#ff6384'])
            ->setWidth(375) // Lebar grafik dalam piksel
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat');
    }
}
