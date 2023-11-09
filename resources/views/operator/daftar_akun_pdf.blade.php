<h3><center>Daftar Akun Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro</center></h3>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th>No</th>
    <th>Nama</th>
    <th>Username</th>
    <th>Password</th>
  </tr>
  {{ $i = 1 }}
  @foreach ($accounts as $account)
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $account->nama }}</td>
        <td>{{ $account->username }}</td>
        <td>{{ $account->password }}</td>
    </tr>
  @endforeach
</table>