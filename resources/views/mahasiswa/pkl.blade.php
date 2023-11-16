@extends('mahasiswa.navsidebar')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

            @if (session('success'))
                <div class="p-4 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <br>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <br>
            @endif
            <h1 class="text-2xl mb-5 font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Progress Praktik Kerja Lapangan
            </h1>
            @if ($pklData && $pklData->count() == 0)
            <div class="m-auto">
                <a href="{{ route('pkl.viewEntry') }}" class="mr-auto text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-400 dark:hover:bg-green-500 focus:outline-none dark:focus:ring-green-600" type="button">
                    + Tambah PKL
                </a>
            </div>
            @endif
            @if ($pklData && $pklData->count() > 0)
                @foreach ($pklData as $pkl)
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                        <h1 class="text-center text-lg font-semibold leading-tight tracking-tight text-gray-900 md:text-lg dark:text-white">
                        @if ($pkl->statusVerif === '0')
                        <span class="text-center text-lg font-semibold leading-tight tracking-tight text-red-600 md:text-lg dark:text-white">
                            Menunggu verifikasi dosen wali
                        @elseif ($pkl->statusVerif === '1')
                            <span class="text-base text-green-600 bg-green-100 p-2 rounded-lg">PKL sudah diverifikasi dosen wali</span>
                        @endif
                        </h1>
                        <br>
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
                        @if ($pkl->statusVerif === '0')
                        <div class="form-group mt-2">
                            <a href="{{ route('pkl.viewEditPKL2', ['id' => $pkl->idPKL]) }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                type="button">
                                Edit 
                            </a>
                            <a href="{{ route('pkl.delete2', ['id' => $pkl->idPKL]) }}"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                type="button">
                                Delete 
                            </a>
                        </div>
                        @endif
                    </div>
                @endforeach
            @else
                <br>
                <p class="text-base text-gray-500 dark:text-gray-400">Belum ada progress PKL</p>
            @endif
        </div>
    </div>
</div>
@endsection