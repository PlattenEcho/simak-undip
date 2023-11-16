@extends('mahasiswa.navsidebar')

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
            <h1
                class="text-2xl mb-5 font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Progress Kartu Hasil Studi
            </h1>
            <div class="m-auto">
                <a href="{{ route('khs.viewEntry') }}" class="mr-auto text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-400 dark:hover:bg-green-500 focus:outline-none dark:focus:ring-green-600" type="button">
                    + Tambah KHS
                </a>
            </div>
    </div>

    <div id="accordion-collapse" data-accordion="collapse">
        @if($khsData->count() > 0)
                @foreach ($khsData as $khs)
                <h2 id="accordion-collapse-heading-{{ $khs->semester }}">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover-bg-gray-800" data-accordion-target="#accordion-collapse-body-{{ $khs->semester }}" aria-expanded="false" aria-controls="accordion-collapse-body-{{ $khs->semester }}">
                        <span class="text-l font-semibold leading-tight tracking-tight text-gray-900 md:text-l dark:text-white">Semester {{ $khs->semester }} | Jumlah SKS {{ $khs->sks_smt }} | IP Semester {{ $khs->ips }}</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-{{ $khs->semester }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $khs->semester }}">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                        <h1 class="text-center text-lg font-semibold leading-tight tracking-tight text-gray-900 md:text-lg dark:text-white">
                        @if ($khs->status === '0')
                            <span class="text-center text-lg font-semibold leading-tight tracking-tight text-red-600 md:text-lg dark:text-white">
                            Menunggu verifikasi dosen wali
                        @elseif ($khs->status === '1')
                            <span class="text-base text-green-600 bg-green-100 p-2 rounded-lg">KHS sudah diverifikasi dosen wali</span>
                        @endif
                        </h1>
                        <br>
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
                        @if ($khs->status === '0')
                        <div class="form-group mt-2">
                            <a href="{{ route('khs.viewEditKHS2', ['id' => $khs->id_khs]) }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                type="button">
                                Edit
                            </a>
                            <a href="{{ route('khs.delete2', ['id' => $khs->id_khs]) }}"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                type="button">
                                Delete
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                @else
                    <br>
                    <p class="text-base text-gray-500 dark:text-gray-400">Belum ada progress KHS</p>
                @endif  
            </div>
        </div>
    </div>
</div>

@endsection