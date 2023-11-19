<h3><center>Rekap Status Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro</center></h3>

<table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Status</th>
        @foreach ($daftarAngkatan as $angkatan)
        <th>{{ $angkatan }}</th>
        @endforeach
    </tr>
    <tr>
        <td>Aktif</td>
        @foreach ($daftarAngkatan as $angkatan)
        <td>{{ $aktif[$angkatan] }}</td>
        @endforeach
    </tr>
    <tr>
        <td>Cuti</td>
        @foreach ($daftarAngkatan as $angkatan)
        <td>{{ $cuti[$angkatan] }}</td>
        @endforeach
    </tr>
    <tr>
        <td>Mangkir</td>
        @foreach ($daftarAngkatan as $angkatan)
        <td>{{ $mangkir[$angkatan] }}</td>
        @endforeach
    </tr>
    <tr>
        <td>Drop Out</td>
        @foreach ($daftarAngkatan as $angkatan)
        <td>{{ $do[$angkatan] }}</td>
        @endforeach
    </tr>
    <tr>
        <td>Undur Diri</td>
        @foreach ($daftarAngkatan as $angkatan)
        <td>{{ $undurDiri[$angkatan] }}</td>
        @endforeach
    </tr>
    <tr>
        <td>Lulus</td>
        @foreach ($daftarAngkatan as $angkatan)
        <td>{{ $lulus[$angkatan] }}</td>
        @endforeach
    </tr>
    <tr>
        <td>Meninggal Dunia</td>
        @foreach ($daftarAngkatan as $angkatan)
        <td>{{ $md[$angkatan] }}</td>
        @endforeach
    </tr>

</table>
