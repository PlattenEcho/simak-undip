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
            ->where('statusVerif', '1') // Menambahkan kondisi statusVerif
            ->pluck('nim')
            ->toArray();

        $jumlahSudahSkripsi = count(array_unique($skripsiMahasiswaPerwalian));
        $jumlahBelumSkripsi = count($mahasiswaPerwalian) - $jumlahSudahSkripsi;


        return $this->chart->barChart()
            ->addData('Jumlah Mahasiswa', [$jumlahSudahSkripsi, $jumlahBelumSkripsi])
            ->setXAxis(['Sudah', 'Belum'])
            ->setWidth(325) // Lebar grafik dalam piksel
            ->setHeight(325) // Tinggi grafik dalam piksel
            ->setFontFamily('Montserrat');
    }
}
