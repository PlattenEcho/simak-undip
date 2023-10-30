@extends('doswal.navsidebar')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

            @if (session('success'))
                <div class="p-4 mr-2 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
            <br>
            <h1
                class="text-l mb-5 font-semibold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                Informasi Akademik Mahasiswa
            </h1>
            <form class="space-y-4 md:space-y-6" method="GET" autocomplete="on" action="" >
            <div class="flex flex-col items-center mb-6">
                <div class="relative w-20 h-20 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                    <img src="{{ $foto }}" alt="user photo" class="w-20 h-20 object-cover" />
                </div>
            </div>
            <div class="form-group">
                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                <input type="text" id="nim" name="nim" value="{{ $mahasiswa->nim }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
            </div>
            <div class="form-group">
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ Auth::user()->name }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
            </div>
            <div class="form-group">
                <label for="angkatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Angkatan</label>
                <input type="text" id="angkatan" name="angkatan" value="{{ $mahasiswa->angkatan }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
            </div>
            <div class="form-group">
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <input type="text" id="status" name="status" value="{{ $mahasiswa->status }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
            </div>
            <div class="form-group">
                <label for="doswal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dosen Wali</label>
                <input type="text" id="doswal" name="doswal" value="{{ $mahasiswa->dosen_wali->nama }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
            </div>
            <!-- <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester:</label>
                <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Pilih Semester</option>
                    @foreach ($allSemester as $semester)
                        <option value="{{ $semester }}">{{ $semester }}</option>
                    @endforeach
                </select> -->
                <div>
                <button data-modal-target="semesterModal" data-modal-toggle="semesterModal" class="mr-auto text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-400 dark:hover:bg-green-500 focus:outline-none dark:focus:ring-green-600" type="button">
                    Pilih Semester
                </button>
                </div>
                <!-- Main modal -->
                <div id="semesterModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="semesterModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="px-6 py-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Masukkan Semester</h3>
                                <form class="space-y-6" action="">
                                    <div>
                                        <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                                        <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                            <option value="">Pilih Semester</option>
                                            <?php
                                            for ($i = 1; $i <= 14; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pilih</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
            @if ($irs or $khs or $pkl or $skripsi)
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                    <li class="mr-2">
                        <button id="irs-tab" data-tabs-target="#irs" type="button" role="tab" aria-controls="irs" aria-selected="true" class="inline-block p-4 text-blue-600 rounded-tl-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">IRS</button>
                    </li>
                    <li class="mr-2">
                        <button id="khs-tab" data-tabs-target="#khs" type="button" role="tab" aria-controls="khs" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">KHS</button>
                    </li>
                    <li class="mr-2">
                        <button id="pkl-tab" data-tabs-target="#pkl" type="button" role="tab" aria-controls="pkl" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">PKL</button>
                    </li>
                    <li class="mr-2">
                        <button id="skripsi-tab" data-tabs-target="#skripsi" type="button" role="tab" aria-controls="skripsi" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Skripsi</button>
                    </li>
                </ul>
                <div id="defaultTabContent">
                    @if($irs)
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="irs" role="tabpanel" aria-labelledby="irs-tab">
                        <div class="form-group">
                            <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                                <input type="text" id="semester" name="semester" value="{{ $irs->semester }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                            </div>
                            <div class="form-group">
                                <label for="jml_sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS</label>
                                <input type="text" id="jml_sks" name="jml_sks" value="{{ $irs->jml_sks }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                            </div>
                            <div class="form-group">
                                <label for="scan_irs" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan IRS <a href="{{ asset('storage/' . $irs->scan_irs) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat file</a></label>
                            </div>
                            @if($irs->status == 'Unverified')
                            <div class="m-auto">
                                <br>
                                <a href="#" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Verifikasi</a>
                                <a href="#" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Reject</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="irs" role="tabpanel" aria-labelledby="irs-tab">
                        <p class="mb-3 text-gray-500 dark:text-gray-400">Belum ada progress IRS</p>
                    </div>
                    @endif
                    @if($khs)
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="khs" role="tabpanel" aria-labelledby="khs-tab">
                        <div class="form-group">
                            <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                            <input type="text" id="semester" name="semester" value="{{ $khs->semester }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="sks_smt" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS Semester</label>
                            <input type="text" id="sks_smt" name="sks_smt" value="{{ $khs->sks_smt }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="sks_kum" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS Kumulatif</label>
                            <input type="text" id="sks_kum" name="sks_kum" value="{{ $khs->sks_kum }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="ips" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Semester</label>
                            <input type="text" id="ips" name="ips" value="{{ $khs->ips }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="ipk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Kumulatif</label>
                            <input type="text" id="ipk" name="ipk" value="{{ $khs->ipk }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="scan_khs" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan KHS <a href="{{ asset('storage/' . $khs->scan_khs) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat file</a></label>
                        </div>
                    </div>
                    @else
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="khs" role="tabpanel" aria-labelledby="khs-tab">
                        <p class="mb-3 text-gray-500 dark:text-gray-400">Belum ada progress KHS</p>
                    </div>
                    @endif
                    @if($pkl)
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="pkl" role="tabpanel" aria-labelledby="pkl-tab">
                        <div class="form-group">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <input type="text" id="status" name="status" value="{{ $pkl->status }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="nilai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                            <input type="text" id="nilai" name="nilai" value="{{ $pkl->nilai }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="scan_pkl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan PKL <a href="{{ asset('storage/' . $pkl->scan_pkl) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat file</a></label>
                        </div>
                    </div>
                    @else
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="pkl" role="tabpanel" aria-labelledby="pkl-tab">
                        <p class="mb-3 text-gray-500 dark:text-gray-400">Belum ada progress PKL</p>
                    </div>
                    @endif
                    @if($skripsi)
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="skripsi" role="tabpanel" aria-labelledby="skripsi-tab">
                        <div class="form-group">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <input type="text" id="status" name="status" value="{{ $skripsi->status }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="nilai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                            <input type="text" id="nilai" name="nilai" value="{{ $skripsi->nilai }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </div>
                        <div class="form-group">
                            <label for="scan_pkl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan PKL <a href="{{ asset('storage/' . $skripsi->scan_skripsi) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat file</a></label>
                        </div>
                    </div>
                    @else
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="skripsi" role="tabpanel" aria-labelledby="skripsi-tab">
                        <p class="mb-3 text-gray-500 dark:text-gray-400">Belum ada progress skripsi</p>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@else
<p class="text-lg text-gray-500 dark:text-gray-400">Belum ada progress</p>
@endif
<!-- <script>
    var semesterDropdown = document.getElementById('semester');
    var irsContent = document.getElementById('irs-content');
    var semesterInput = document.getElementById('semester'); // Input untuk menampilkan semester
    var sksInput = document.getElementById('jml_sks'); // Input untuk menampilkan jumlah SKS
    var scanIRSLink = document.querySelector('a[href=""]'); // Tautan untuk menampilkan scan IRS

    semesterDropdown.addEventListener('change', function() {
        var selectedSemester = this.value;
        if (semesterDropdown.value === "") {
        irsContent.style.display = 'none';
    }

        if (selectedSemester !== "") {
            // Menggunakan JavaScript untuk memfilter data IRS sesuai semester yang dipilih
            var filteredData = allIRSData.filter(function(irs) {
                return irs.semester === selectedSemester;
            });

            if (filteredData.length > 0) {
                var irs = filteredData[0]; // Mengambil data IRS pertama (atau yang sesuai)

                // Mengisi nilai input dengan data IRS
                semesterInput.value = irs.semester; // Ganti dengan atribut yang sesuai
                sksInput.value = irs.jumlah_sks; // Ganti dengan atribut yang sesuai
                scanIRSLink.href = irs.scan_irs; // Ganti dengan atribut yang sesuai
            }

            irsContent.style.display = 'block';
        } else {
            irsContent.style.display = 'none';

            // Mengosongkan nilai input dan tautan
            semesterInput.value = '';
            sksInput.value = '';
            scanIRSLink.href = '';
        }

        
    });
</script> -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
@endsection