<h3><center>Rekap Status Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro</center></h3>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="7">Angkatan {{ $tahun }}</th>
    </tr>
    <tr>
        <th>Aktif</th>
        <th>Cuti</th>
        <th>Mangkir</th>
        <th>Drop Out</th>
        <th>Undur Diri</th>
        <th>Lulus</th>
        <th>Meninggal Dunia</th>
    </tr>
    <tr>
        <td>{{ $aktif }}</td>
        <td>{{ $cuti }}</td>
        <td>{{ $mangkir }}</td>
        <td>{{ $do }}</td>
        <td>{{ $undurDiri }}</td>
        <td>{{ $lulus }}</td>
        <td>{{ $md }}</td>
    </tr>
</table>