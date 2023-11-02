@extends('mahasiswa.navsidebar')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <div class="p-4 flex items-center h-48 mb-4 rounded-lg border-2 border-gray-200 bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="w-40 h-40 rounded-full overflow-hidden">
                        <img src= "{{ asset('storage/' . auth()->user()->foto) }}" alt="{{ $mahasiswa->nama }}">
                    </div>
                    <div class="ml-6">
                        <p class="text-xl font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-lg text-gray-600">{{ $mahasiswa->nim }}</p>
                        <p class="text-lg text-gray-600">Mahasiswa Departemen Informatika</p>

                    </div>
                </div>
            </div>

            <div class="flex flex-wrap w-full max-w-8xl">
                <div class="w-auto rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800 mb-4 mr-4"
                    style="width: 32.4%;">
                    <div class="mx-4 my-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        IPK
                    </div>
                    @if($ipkTertinggi)
                    <div class="mx-4 my-4 text-right text-lg font-bold text-gray-800 dark:text-gray-500">
                        {{ $ipkTertinggi->ipk }} </div>
                   
                    @else
                    <div class="mx-4 my-4 text-right text-lg font-bold text-gray-800 dark:text-gray-500">
                        0.00 </div>
                    @endif
                </div>
                <div class=" w-auto rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800 mr-4"
                    style="width: 32.4%;">
                    <div class="mx-4 my-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        SKS Kumulatif
                    </div>
                    <div class="mx-4 my-4 text-right text-lg font-bold text-gray-800 dark:text-gray-500">
                        {{ $mahasiswa->irs->sum('jml_sks') }} </div>
                </div>
                <div class=" w-auto rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800"
                    style="width: 32.4%;">
                    <div class="mx-4 my-4 text-sm font-semibold text-gray-800 dark:text-gray-500">
                        Semester Aktif
                    </div>
                    <div class="mx-4 my-4 text-right text-lg font-bold text-gray-800 dark:text-gray-500">
                        {{ $mahasiswa->irs->max('semester') }} </div>
                </div>
                <div class=" w-auto rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800 mr-4"
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
                </div>

            </div>

            </section>
        @endsection
