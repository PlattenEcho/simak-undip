<h3><center>Daftar Belum Skripsi Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro</center></h3>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th>Nama</th>
    <th>NIM</th>
    <th>Angkatan</th>
  </tr>
  @foreach ($belumSkripsi as $mhs)
    <tr>
        <td>{{ $mhs->nama }}</td>
        <td>{{ $mhs->nim }}</td>
        <td>{{ $mhs->angkatan }}</td>
    </tr>
  @endforeach
</table>