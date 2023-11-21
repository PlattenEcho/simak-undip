<h3><center>Rekap Skripsi Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro</center></h3>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="10">Angkatan</th>
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
        <td>{{ $sudahSkripsi[$tahun] }}</td>
        <td>{{ $belumSkripsi[$tahun] }}</td>
        @endfor
    </tr>
</table>