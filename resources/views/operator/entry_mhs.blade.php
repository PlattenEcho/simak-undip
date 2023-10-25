<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>SIMAK Undip</title>
</head>
<body>
<div class="container">
<div class="card mt-4">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card-header">Entry Data Mahasiswa</div>
    <div class="card-body">
        <form method="POST" autocomplete="on" action="{{ route('mahasiswa.store') }}" >
            @csrf
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}">
                @error('nim')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                @error('nama')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="angkatan">Angkatan:</label>
                <input type="text" class="form-control" id="angkatan" name="angkatan" value="{{ old('angkatan') }}">
                @error('angkatan')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Dropout" {{ old('status') == 'Dropout' ? 'selected' : '' }}>Dropout</option>
                </select>
                @error('status')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jalur_masuk">Jalur Masuk:</label>
                <select class="form-control" id="jalur_masuk" name="jalur_masuk">
                    <option value="" selected>-- Pilih Jalur Masuk --</option>
                    <option value="SBUB" {{ old('jalur_masuk') == 'SBUB' ? 'selected' : '' }}>SBUB</option>
                    <option value="SNMPTN" {{ old('jalur_masuk') == 'SNMPTN' ? 'selected' : '' }}>SNMPTN</option>
                    <option value="SBMPTN" {{ old('jalur_masuk') == 'SBMPTN' ? 'selected' : '' }}>SBMPTN</option>
                    <option value="Mandiri" {{ old('jalur_masuk') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                </select>
                @error('jalur_masuk')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="doswal">Dosen Wali:</label>
                <select class="form-control" id="doswal" name="doswal">
                    <option value="">-- Pilih Dosen Wali --</option>
                    @foreach($dosen_wali as $dosen)
                        <option value="{{ $dosen->nip }}" {{ old('doswal') == $dosen->nip ? 'selected' : '' }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('doswal')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            
            <a href="{{ route('mahasiswa.showEntry') }}" class="btn btn-secondary">Reset</a>
            <button type="submit" class="btn btn-success" id="generate-account-button" name="submit" value="generate">Generate Account</button>
        </form>
        
    </div>
</div>
</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
@if(session('success'))
    <script>
        document.getElementById('generate-account-button').removeAttribute('disabled');
    </script> --}}
{{-- @endif
<script>
    document.getElementById('generate-account-button').addEventListener('click', function() {
    // Lakukan permintaan Ajax untuk generate account
    $.ajax({
        method: 'POST',
        url: '/generate-account', // Ganti dengan URL yang sesuai
        data: { nim: 'nim-mahasiswa' }, // Ganti dengan NIM mahasiswa yang sesuai
        success: function() {
            // Tampilkan modal popup
            var popup = document.getElementById('account-info-popup');
            popup.style.display = 'block';
        },
        error: function(xhr, status, error) {
            alert('Terjadi kesalahan: ' + error);
        }
    });
});

</script> --}}
</body>
</html>