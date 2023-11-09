<h3><center>Daftar Belum Lulus PKL Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro</center></h3>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th>Nama</th>
    <th>NIM</th>
    <th>Angkatan</th>
    <th>Nilai</th>
  </tr>
  @foreach ($pklData as $pkl)
    <tr>
        <td>{{ $pkl->mahasiswa->nama }}</td>
        <td>{{ $pkl->mahasiswa->nim }}</td>
        <td>{{ $pkl->mahasiswa->angkatan }}</td>
        <td>{{ $pkl->nilai }}</td>
    </tr>
  @endforeach
</table>