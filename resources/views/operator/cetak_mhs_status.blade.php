<h3><center>Daftar Mahasiswa {{$status}}</center></h3>
<table border="1" cellspacing="0" cellpadding="3">
  <tr>
    <th>Nama</th>
    <th>NIM</th>
    <th>Angkatan</th>
    <th>Status</th>
    <th>Jalur Masuk</th>
    <th>Alamat</th>
    <th>Kabupaten</th>
    <th>Provinsi</th>
    <th>Nomor Telepon</th>
  </tr>
  @foreach ($mhsData as $mhs)
    <tr>
        <td>{{ $mhs['nama'] }}</td>
        <td>{{ $mhs['nim'] }}</td>
        <td>{{ $mhs['angkatan'] }}</td>
        <td>{{ $mhs['status'] }}</td>
        <td>{{ $mhs['jalur_masuk'] }}</td>
        <td>{{ $mhs['alamat'] }}</td>
        <td>{{ $mhs['kabupaten'] }}</td>
        <td>{{ $mhs['provinsi'] }}</td>
        <td>{{ $mhs['nomor_telepon'] }}</td>
    </tr>
  @endforeach
</table>