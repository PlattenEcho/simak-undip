<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class MahasiswaImport implements ToModel
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         return new Mahasiswa([
//             'nim'     => $row[0],
//             'nama'    => $row[1], 
//             'angkatan'    => $row[2], 
//             'status'    => $row[3], 
//             'jalur_masuk'    => $row[4],
//             'nip'    => $row[5], 
//         ]);
//     }
// }

class MahasiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Mahasiswa([
            'nama' => $row['nama'],
            'nim' => $row['nim'],
            'angkatan' => $row['angkatan'],
            'status' => $row['status'],
            'jalur_masuk' => $row['jalur_masuk'],
            'nip' => $row['nip']
        ]);
    }
}