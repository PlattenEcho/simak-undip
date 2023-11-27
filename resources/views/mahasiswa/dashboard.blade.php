@extends('mahasiswa.navsidebar')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-20">
            <div class="flex flex-wrap w-full max-w-8xl">
                <div class="p-10 flex items-center h-48 mb-4 mr-4 rounded-lg border-2 border-gray-200 bg-gray-50 dark:bg-gray-800"
                    style="width: 55%;">
                    <div class="flex items-center">
                        <div class="w-40 h-40 rounded-full overflow-hidden">
                            @if (auth()->user()->foto)
                                <img src= "{{ asset('storage/' . auth()->user()->foto) }}">
                            @else
                                <img
                                    src= "https://t4.ftcdn.net/jpg/05/89/93/27/360_F_589932782_vQAEAZhHnq1QCGu5ikwrYaQD0Mmurm0N.jpg">
                            @endif
                        </div>
                        <div class="ml-6">
                            <p class="text-xl font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-lg text-gray-600">{{ $mahasiswa->nim }}</p>
                            <p class="text-lg text-gray-600">Mahasiswa Departemen Informatika</p>
                        </div>
                    </div>
                </div>
                <div class=" w-auto rounded-lg border-2 border-gray-200 h-48 rounded bg-gray-50 dark:bg-gray-800"
                    style="width: 43%;">
                    <div class="mx-4 mt-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        Informasi Mahasiswa
                    </div>
                    <div class="mx-4 my-4 text-right text-justify font-medium text-sm text-gray-800 dark:text-gray-500">
                        @if (isset($ipkTertinggi->ipk))
                            <p class="text-base text-left text-gray-600"> IPK : {{ $ipkTertinggi->ipk }}</p>
                        @else
                            <p class="text-base text-left text-gray-600"> IPK : 0.00</p>
                        @endif
                        <p class="text-base text-left text-gray-600"> SKS Kumulatif :
                            {{ $mahasiswa->khs->sum('sks_smt') }}
                        </p>
                        <p class="text-base text-left text-gray-600"> Semester Aktif : {{ $semesterAktif }}</p>
                        <p class="text-base text-left text-gray-600"> Dosen Wali : {{ $mahasiswa->dosen_wali->nama }}</p>
                        <p class="text-base text-left text-gray-600"> Status Akademik :
                            {{ $mahasiswa->status }}</p>
                    </div>
                </div>
                <div class="w-auto rounded-lg border-2 border-gray-200 h-28 rounded bg-gray-50 dark:bg-gray-800 mb-4"
                    style="width: 100%;">
                    <div class="mx-4 my-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        Semester
                    </div>
                    <div class="mx-4 my-4 text-lg font-bold text-gray-800 dark:text-gray-500">
                        @for ($i = 1; $i <= 14; $i++)
                            <div class="inline-block">
                                @if (count($skripsi[$i]) > 0)
                                    @if ($skripsi[$i][0]->statusVerif == '1')
                                        <a data-modal-target="modal-{{ $i }}"
                                            data-modal-toggle="modal-{{ $i }}" type="button"
                                            class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-300 dark:focus:ring-green-400">{{ $i }}</a>
                                    @endif
                                @elseif (count($PKL[$i]) > 0)
                                    @if ($PKL[$i][0]->statusVerif == '1')
                                        <a data-modal-target="modal-{{ $i }}"
                                            data-modal-toggle="modal-{{ $i }}" type="button"
                                            class="text-white bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:focus:ring-yellow-400">{{ $i }}</a>
                                    @endif
                                @elseif (count($allKHS[$i]) > 0)
                                    @if ($allKHS[$i][0]->status == '1')
                                        <a data-modal-target="modal-{{ $i }}"
                                            data-modal-toggle="modal-{{ $i }}" type="button"
                                            class="text-white bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-400 dark:focus:ring-blue-500">{{ $i }}</a>
                                    @endif
                                @elseif (count($allIRS[$i]) > 0)
                                    @if ($allIRS[$i][0]->status == '1')
                                        <a data-modal-target="modal-{{ $i }}"
                                            data-modal-toggle="modal-{{ $i }}" type="button"
                                            class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-400 dark:focus:ring-blue-500">{{ $i }}</a>
                                    @else
                                        <a data-modal-target="modal-{{ $i }}"
                                            data-modal-toggle="modal-{{ $i }}" type="button"
                                            class="text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-400 dark:focus:ring-red-500">{{ $i }}</a>
                                    @endif
                                @else
                                    <span href="#" data-modal-target="modal-{{ $i }}"
                                        data-modal-toggle="modal-{{ $i }}"
                                        class="text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-400 dark:focus:ring-red-500">{{ $i }}</span>
                                @endif
                                <div id="modal-{{ $i }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="modal-{{ $i }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <br>
                                            <div
                                                class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800"
                                                    id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                                                    <li class="me-2">
                                                        <button id="irs-tab-{{ $i }}"
                                                            data-tabs-target="#irs-{{ $i }}" type="button"
                                                            role="tab" aria-controls="irs" aria-selected="true"
                                                            class="inline-block p-4 text-blue-600 rounded-ss-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">IRS</button>
                                                    </li>
                                                    <li class="me-2">
                                                        <button id="khs-tab-{{ $i }}"
                                                            data-tabs-target="#khs-{{ $i }}" type="button"
                                                            role="tab" aria-controls="khs" aria-selected="false"
                                                            class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">KHS</button>
                                                    </li>
                                                    <li class="me-2">
                                                        <button id="pkl-tab-{{ $i }}"
                                                            data-tabs-target="#pkl-{{ $i }}" type="button"
                                                            role="tab" aria-controls="pkl" aria-selected="false"
                                                            class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">PKL</button>
                                                    </li>
                                                    <li class="me-2">
                                                        <button id="skripsi-tab-{{ $i }}"
                                                            data-tabs-target="#skripsi-{{ $i }}"
                                                            type="button" role="tab" aria-controls="skripsi"
                                                            aria-selected="false"
                                                            class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Skripsi</button>
                                                    </li>
                                                </ul>
                                                <div id="defaultTabContent">
                                                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800"
                                                        id="irs-{{ $i }}" role="tabpanel"
                                                        aria-labelledby="irs-tab">
                                                        @if (count($allIRS[$i]) > 0)
                                                            <div class="form-group">
                                                                <label for="semester"
                                                                    class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                                                                <input type="text" id="semester" name="semester"
                                                                    value="{{ $allIRS[$i][0]->semester }}"
                                                                    aria-label="disabled input"
                                                                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jml_sks"
                                                                    class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                                                    SKS</label>
                                                                <input type="text" id="jml_sks" name="jml_sks"
                                                                    value="{{ $allIRS[$i][0]->jml_sks }}"
                                                                    aria-label="disabled input"
                                                                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="scan_irs"
                                                                    class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan
                                                                    IRS</label>
                                                                <a href="{{ asset('storage/' . $allIRS[$i][0]->scan_irs) }}"
                                                                    class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat
                                                                    file</a></label>
                                                            </div>
                                                        @else
                                                            <p class="mb-3 text-gray-500 dark:text-gray-400">Tidak ada
                                                                progress IRS</p>
                                                        @endif
                                                    </div>
                                                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800"
                                                        id="khs-{{ $i }}" role="tabpanel"
                                                        aria-labelledby="khs-tab">
                                                        @if (count($allKHS[$i]) > 0)
                                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                                <div class="form-group">
                                                                    <label for="semester"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                                                                    <input type="text" id="semester" name="semester"
                                                                        value="{{ $allKHS[$i][0]->semester }}"
                                                                        aria-label="disabled input"
                                                                        class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="sks_smt"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                                                        SKS Semester</label>
                                                                    <input type="text" id="sks_smt" name="sks_smt"
                                                                        value="{{ $allKHS[$i][0]->sks_smt }}"
                                                                        aria-label="disabled input"
                                                                        class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                                <div class="form-group">
                                                                    <label for="sks_kum"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                                                        SKS Kumulatif</label>
                                                                    <input type="text" id="sks_kum" name="sks_kum"
                                                                        value="{{ $allKHS[$i][0]->sks_kum }}"
                                                                        aria-label="disabled input"
                                                                        class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="ips"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP
                                                                        Semester</label>
                                                                    <input type="text" id="ips" name="ips"
                                                                        value="{{ $allKHS[$i][0]->ips }}"
                                                                        aria-label="disabled input"
                                                                        class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                                <div class="form-group">
                                                                    <label for="ipk"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP
                                                                        Kumulatif</label>
                                                                    <input type="text" id="ipk" name="ipk"
                                                                        value="{{ $allKHS[$i][0]->ipk }}"
                                                                        aria-label="disabled input"
                                                                        class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="scan_khs"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan
                                                                        KHS </label>
                                                                    <a href="{{ asset('storage/' . $allKHS[$i][0]->scan_khs) }}"
                                                                        class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat
                                                                        file</a></label>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <p class="mb-3 text-gray-500 dark:text-gray-400">Tidak ada
                                                                progress KHS</p>
                                                        @endif
                                                    </div>
                                                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800"
                                                        id="pkl-{{ $i }}" role="tabpanel"
                                                        aria-labelledby="pkl-tab">
                                                        @if (count($PKL[$i]) > 0)
                                                            <div class="form-group">
                                                                <label for="status"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                                                <input type="text" id="status" name="status"
                                                                    value="{{ $PKL[$i][0]->status }}"
                                                                    aria-label="disabled input"
                                                                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nilai"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                                                                <input type="text" id="nilai" name="nilai"
                                                                    value="{{ $PKL[$i][0]->nilai }}"
                                                                    aria-label="disabled input"
                                                                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="scan_pkl"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan
                                                                    PKL</label>
                                                                <a href="{{ asset('storage/' . $PKL[$i][0]->scan_pkl) }}"
                                                                    class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat
                                                                    file</a></label>
                                                            </div>
                                                        @else
                                                            <p class="mb-3 text-gray-500 dark:text-gray-400">Tidak ada
                                                                progress PKL</p>
                                                        @endif
                                                    </div>
                                                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800"
                                                        id="skripsi-{{ $i }}" role="tabpanel"
                                                        aria-labelledby="skripsi-tab">
                                                        @if (count($skripsi[$i]) > 0)
                                                            <div class="form-group">
                                                                <label for="status"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                                                <input type="text" id="status" name="status"
                                                                    value="{{ $skripsi[$i][0]->status }}"
                                                                    aria-label="disabled input"
                                                                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nilai"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                                                                <input type="text" id="nilai" name="nilai"
                                                                    value="{{ $skripsi[$i][0]->nilai }}"
                                                                    aria-label="disabled input"
                                                                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="scan_pkl"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan
                                                                    PKL</label>
                                                                <a href="{{ asset('storage/' . $skripsi[$i][0]->scan_skripsi) }}"
                                                                    class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat
                                                                    file</a></label>
                                                            </div>
                                                        @else
                                                            <p class="mb-3 text-gray-500 dark:text-gray-400">Tidak ada
                                                                progress skripsi
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- <div class=" w-auto rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800 mr-4"
                    style="width: 32.4%;">
                    <div class="mx-4 my-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        SKS Kumulatif
                    </div>
                    <div class="mx-4 my-4 text-right text-lg font-bold text-gray-800 dark:text-gray-500">
                        {{ $mahasiswa->khs->sum('sks_smt') }} </div>
                </div>

                <div class=" w-auto rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800"
                    style="width: 32.4%;">
                    <div class="mx-4 my-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        Semester Aktif
                    </div>
                    <div class="mx-4 my-4 text-right text-lg font-bold text-gray-800 dark:text-gray-500">
                        {{ $semesterAktif }} </div>
                </div>

                <div class=" w-auto rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800 mr-4 mb-6"
                    style="width: 32.4%;">
                    <div class="mx-4 my-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        Dosen Wali
                    </div>
                    <div class="mx-4 my-4 text-right text-lg font-bold text-gray-800 dark:text-gray-500">
                        {{ $mahasiswa->dosen_wali->nama }} </div>
                </div>

                <div class=" w-auto rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800 mr-4"
                    style="width: 32.4%;">
                    <div class="mx-4 my-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        Status Akademik
                    </div>
                    <div class="mx-4 my-4 text-right text-lg font-bold text-gray-800 dark:text-gray-500">
                        {{ $mahasiswa->status }} </div>
                </div> --}}

            </div>
            </section>
        @endsection
