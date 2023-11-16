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
                action="{{ route('skripsi.store') }}">
                @csrf
                <div class="form-group">
                    <label for="semester"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester:</label>
                    <select id="semester" name="semester"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option value="{{ $skripsi->semester }}">{{ $skripsi->semester }}</option>
                        @foreach ($remainingSemesters as $semester)
                            <option value="{{ $semester }}">{{ $semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="form-group">
                        <label for="lama_studi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama
                            Studi:</label>
                        <input type="text" id="lama_studi" name="lama_studi" value="{{ $skripsi->lama_studi }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_sidang"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                            Sidang</label>
                        <input type="date" name="tanggal_sidang" id="tanggal_sidang" disabled
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            value="{{ $skripsi->tanggal_sidang }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status:</label>
                    <input type="text" id="status" name="status" aria-label="disabled input" value="Lulus"
                        class="mb-6 bg-gray-100 border border-gray-300 font-medium text-green-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        disabled>
                </div>
                <div class="form-group">
                    <label for="nilai"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai:</label>
                    <select id="nilai" name="nilai" disabled
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option value="{{ $skripsi->nilai }}">{{ $skripsi->nilai }}</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="scan_pkl">Upload Scan
                        Skripsi (PDF only):</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="file_input_help" id="scan_skripsi" name="scan_skripsi" type="file"
                        value="{{ $skripsi->scan_skripsi }}" accept="application/pdf">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF (max 5 MB)</p>
                </div>
                <div class="m-auto">
                    <button type="submit" name="submit"
                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        Delete
                    </button>
                    <a href="#"
                        class="mr-auto text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-400 dark:hover-bg-gray-500 focus:outline-none dark:focus:ring-gray-600">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
