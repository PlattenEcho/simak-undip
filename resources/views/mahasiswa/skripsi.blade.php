@extends('mahasiswa.navsidebar')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

            @if (session('success'))
                <div class="p-4 mr-2 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <br>
            @endif

            @if (session('error'))
                <div class="p-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <br>
            @endif
            <h1 class="text-2xl mb-5 font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Progress Skripsi
            </h1>
            <div class="m-auto">
                @if ($skripsiData && $skripsiData->count() == 0)
                    <a href="/mahasiswa/entry-skripsi"
                        class="mr-auto text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-400 dark:hover:bg-green-500 focus:outline-none dark:focus:ring-green-600"
                        type="button">
                        + Tambah Skripsi
                    </a>
                @endif
            </div>
            @if ($skripsiData && $skripsiData->count() > 0)
                @foreach ($skripsiData as $skripsi)
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                        <h1
                            class="text-center text-lg font-semibold leading-tight tracking-tight text-gray-900 md:text-lg dark:text-white">
                            @if ($skripsi->statusVerif === '0')
                                <span
                                    class="text-center text-lg font-semibold leading-tight tracking-tight text-red-600 md:text-lg dark:text-white">
                                    Menunggu verifikasi dosen wali
                                @elseif ($skripsi->statusVerif === '1')
                                    <span class="text-base text-green-600 bg-green-100 p-2 rounded-lg">Skripsi sudah
                                        diverifikasi dosen wali</span>
                            @endif
                        </h1>
                        <br>
                        <div class="form-group">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <input type="text" id="status" name="status" value="{{ $skripsi->status }}"
                                aria-label="disabled input"
                                class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="nilai"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                            <input type="text" id="nilai" name="nilai" value="{{ $skripsi->nilai }}"
                                aria-label="disabled input"
                                class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                disabled>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="form-group">
                                <label for="lama_studi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama
                                    Studi:</label>
                                <input type="text" id="lama_studi" name="lama_studi" value="{{ $skripsi->lama_studi }}"
                                    aria-label="disabled input" disabled
                                    class="bg-gray-100 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>

                            <div class="form-group">
                                <label for="tanggal_sidang"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                    Sidang</label>
                                <input type="text" name="tanggal_sidang" id="tanggal_sidang"
                                    value="{{ $skripsi->tanggal_sidang }}" aria-label="disabled input" disabled
                                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                        </div>

                        <div class="form-group mt-6">
                            <label for="scan_skripsi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan
                                skripsi <a href="{{ asset('storage/' . $skripsi->scan_skripsi) }}"
                                    class="ml-2 w-24 h-12 bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">Lihat
                                    file</a></label>
                        </div>
                    </div>
                    @if ($skripsi->statusVerif === '0')
                        <div class="form-group mt-2">
                            <a href="{{ route('skripsi.viewEditSkripsiM', ['id' => $skripsi->id_skripsi]) }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                type="button">
                                Edit 
                            </a>
                            <a data-popover-target="popover-delete" href="#" data-modal-target="delete-modal-{{ $skripsi->id_skripsi }}" data-modal-toggle="delete-modal-{{ $skripsi->id_skripsi }}"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                type="button">
                                Delete
                            </a>
                            <div id="delete-modal-{{ $skripsi->id_skripsi }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal-{{ $skripsi->id_skripsi }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda yakin ingin menghapus skripsi ini?</h3>
                                            <form action="{{ route('skripsi.delete2', [$skripsi->id_skripsi]) }}" method="post">
                                                @csrf
                                                <button data-modal-hide="delete-modal-{{ $skripsi->id_skripsi }}" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                                    Ya
                                                </button>
                                                <button data-modal-hide="delete-modal-{{ $skripsi->id_skripsi }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                @endforeach
            @else
                <br>
                <p class="text-base text-gray-500 dark:text-gray-400">Belum ada progress skripsi</p>
            @endif
        </div>
    </div>
    </div>
    </div>
@endsection
