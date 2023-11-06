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
                <input type="text" id="nama" name="nama" value="{{ $mahasiswa->nama }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
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
            <table>
                <label for="semester" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                <td>
                <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Pilih Semester</option>
                    @for ($i = 1; $i <= 14; $i++)
                        <option value="{{ $i }}" @if(old('semester') == $i) selected @endif>{{ $i }}</option>
                    @endfor
                </select>
                </td>
                <td>
                    <button type="submit" class="w-full text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-400 dark:focus:ring-green-500">Pilih</button>
                </td>    
            </table>
            <div>
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
                        <!-- @if($skripsi->statusVerif == 'Unverified')
                            <div class="m-auto">
                            <br>
                                <table>
                                    <td>
                                        <form action="{{ route('skripsi.verifikasi', $skripsi->id_skripsi) }}" method="post">
                                            @csrf
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Verifikasi</button>
                                        </form> 
                                    </td>
                                    <td>    
                                        <form action="{{ route('skripsi.reject', $skripsi->id_skripsi) }}" method="post">
                                            @csrf
                                            <button type="submit" class="text-white bg-pink-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Reject</button>
                                        </form>  
                                    </td>
                                </table>     
                            </div>
                        @endif -->
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
<p class="text-lg text-gray-500 dark:text-gray-400"></p>
@endif

@endsection