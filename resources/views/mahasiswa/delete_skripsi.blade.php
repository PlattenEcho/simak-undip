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
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <br>
            @endif
            <h1 class="text-l mb-1 font-semibold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                Delete Skripsi
            </h1>
            <h1 class="mb-5 text-center text-xl font-bold tracking-tight text-red-600 dark:text-white">Apakah anda yakin mau
                menghapus
                entry skripsi? </h1>

            <form enctype="multipart/form-data" class="space-y-4 md:space-y-6" method="POST" autocomplete="on"
                action="{{ route('skripsi.deleteM', ['id' => $skripsi->id_skripsi]) }}">
                @csrf
                <div class="form-group">
                    <label for="semester"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester:</label>
                    <input type="text" id="semester" name="semester" value="{{ $skripsi->semester }}"
                        aria-label="disabled input" disabled
                        class="mb-6 text-gray-500 bg-gray-100 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="form-group">
                        <label for="lama_studi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama
                            Studi:</label>
                        <input type="text" id="lama_studi" name="lama_studi" value="{{ $skripsi->lama_studi }}"
                            aria-label="disabled input" disabled
                            class="bg-gray-100 text-gray-500 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_sidang"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                            Sidang</label>
                        <input type="date" name="tanggal_sidang" id="tanggal_sidang" disabled
                            class="bg-gray-100 text-gray-500 border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $skripsi->tanggal_sidang }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status:</label>
                    <input type="text" id="status" name="status" disabled aria-label="disabled input" value="Lulus"
                        class="text-green-600 mb-6 bg-gray-100 border border-gray-300 font-medium  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        disabled>
                </div>
                <div class="form-group">
                    <label for="nilai"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai:</label>
                    <input type="text" id="nilai" name="nilai" value="{{ $skripsi->nilai }}" disabled
                        aria-label="disabled input"
                        class="mb-6 bg-gray-100 text-gray-500 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="scan_skripsi">Upload
                        Scan
                        Skripsi (PDF only):</label>
                    <input type="text" id="scan_skripsi" name="scan_skripsi" disabled aria-label="disabled input"
                        value="{{ isset($skripsi->scan_skripsi) ? basename($skripsi->scan_skripsi) : '' }}"
                        class="mb-6 bg-gray-100 text-gray-500 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div class="m-auto">
                    <button type="submit" name="submit"
                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        Delete
                    </button>
                    <a href="/mahasiswa/skripsi"
                        class="mr-auto text-white text-gray-500 bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-400 dark:hover-bg-gray-500 focus:outline-none dark:focus:ring-gray-600">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
