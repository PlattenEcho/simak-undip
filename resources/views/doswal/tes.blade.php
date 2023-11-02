@extends('layouts.layoutMahasiswa')

@section('content')
    <div class="container-lg my-5 text-light">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-journal-check"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-end my-4">
            <a href="{{ route('irs.create') }}" class="btn btn-primary btn-sm">+ Tambah IRS</a>
        </div>

        <hr>

        <div class="d-flex justify-content-center my-3">
            <h2>Daftar IRS</h2>
        </div>

        <div class="d-flex justify-content-center mb-5">
            <div class="card mb-3 w-50">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src=" {{ Auth::user()->getImageURL() }} " class="img-thumbnail h-100 w-100" alt="foto-profil">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ Auth::user()->mahasiswa->nama }}</h5>
                            <p class="card-text">{{ Auth::user()->mahasiswa->nim }}</p>
                            <hr>
                            <p class="card-text"><small class="text-muted">Program Studi S1 Informatika</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-start">
            @if ($irsData->count() > 0)
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownSemester"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Pilih Semester Aktif
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownSemester">
                        @foreach ($irsData as $irs)
                            <li class="dropdown-item" data-semester="{{ $irs->semester_aktif }}">{{ $irs->semester_aktif }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div id="irsDetail" class="ms-3" style="display: none;">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Semester Aktif</th>
                                <th scope="col">Jumlah SKS</th>
                                <th scope="col">Status</th>
                                <th scope="col">Scan IRS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($irsData as $irs)
                                <tr class="irs-row" data-semester="{{ $irs->semester_aktif }}">
                                    <td scope="row">{{ $irs->semester_aktif }}</td>
                                    <td>{{ $irs->jumlah_sks }}</td>
                                    <td>{{ $irs->status }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $irs->scanIRS) }}" target="_blank">Lihat IRS</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="d-flex justify-content-center">
                    <p class="lead">
                        <span class="text-danger"><i class="bi bi-exclamation-circle-fill"></i></span> Belum ada IRS yang
                        diisi.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Handle dropdown item click
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', () => {
                const selectedSemester = item.getAttribute('data-semester');
                showIRSDetail(selectedSemester);
            });
        });

        // Show IRS detail based on selected semester
        function showIRSDetail(semester) {
            document.querySelectorAll('.irs-row').forEach(row => {
                row.style.display = row.getAttribute('data-semester') === semester ? 'table-row' : 'none';
            });
            document.getElementById('irsDetail').style.display = 'block';
        }
    </script>
@endsection