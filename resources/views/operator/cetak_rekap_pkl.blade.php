<h3><center>Rekap PKL Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro</center></h3>
<table border="1" cellspacing="0" cellpadding="3">
  <tr>
    <th colspan=" {{ ($tahun2 - $tahun1 + 1) * 2 }} ">Angkatan</th>
    </tr>
    <tr>
        @for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++)
        <th colspan="2">
            {{ $tahun }}
        </th>
        @endfor
    </tr>
    <tr>
        @for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++)
        <th>Sudah</th>
        <th>Belum</th>
        @endfor
    </tr>
    <tr>
        @for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++)
        <td>{{ $sudahPKL[$tahun] }}</td>
        <td>{{ $belumPKL[$tahun] }}</td>
        @endfor
    </tr>
</table>