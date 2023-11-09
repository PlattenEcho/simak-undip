<h3><center>Daftar Belum Lulus Skripsi Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro</center></h3>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th>Nama</th>
    <th>NIM</th>
    <th>Angkatan</th>
    <th>Nilai</th>
    <th>Tanggal Sidang</th>
    <th>Lama Studi</th>
  </tr>
  @foreach ($skripsiData as $skripsi)
    <tr>
        <td>{{ $skripsi->mahasiswa->nama }}</td>
        <td>{{ $skripsi->mahasiswa->nim }}</td>
        <td>{{ $skripsi->mahasiswa->angkatan }}</td>
        <td>{{ $skripsi->nilai }}</td>
        <td>{{ $skripsi->tanggal_sidang }}</td>
        <td>{{ $skripsi->lama_studi }}</td>
    </tr>
  @endforeach
</table>