@extends('departemen.navsidebar')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <div class="p-4 flex items-center h-48 mb-4 rounded-lg border-2 border-gray-200 bg-gray-50 dark:bg-gray-800">
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
                        <p class="text-lg text-gray-600">Departemen Informatika</p>
                    </div>
                </div>
            </div>
            <div class="grid gap-4 grid-cols-1">
                <div class="grid gap-4 grid-cols-3 grid-rows-1 lg:w-2/3 sm:w-full">
                    <div class="rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="mx-4 my-4 text-xs font-semibold text-gray-800 dark:text-gray-500 md:text-xs lg:text-sm">
                            Total Mahasiswa
                        </div>
                        <div
                            class="mx-4 my-4 text-right text-sm font-bold text-gray-800 dark:text-gray-500 md:text-sm lg:text-lg">
                            {{ $mahasiswaCount }} </div>
                    </div>
                    <div class="rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="mx-4 my-4 text-xs font-semibold text-gray-800 dark:text-gray-500 md:text-xs lg:text-sm">
                            Mahasiswa Aktif
                        </div>
                        <div
                            class="mx-4 my-4 text-right text-xs font-bold text-gray-800 dark:text-gray-500 md:text-sm lg:text-lg">
                            {{ $mahasiswaAktifCount }} </div>
                    </div>
                    <div class="rounded-lg border-2 border-gray-200 h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <div class="mx-4 my-4 text-xs font-semibold text-gray-800 dark:text-gray-500 md:text-xs lg:text-sm">
                            Mahasiswa Non-Aktif
                        </div>
                        <div
                            class="mx-4 my-4 text-right text-xs font-bold text-gray-800 dark:text-gray-500 md:text-sm lg:text-lg">
                            {{ $mahasiswaTidakAktifCount }} </div>
                    </div>
                </div>
                <div id = 'mahasiswaChartContainer'
                    class="p-4 flex rounded-lg border-2 border-gray-200 h-96 rounded bg-gray-50 dark:bg-gray-800">
                    <div>
                        <div class=" text-sm font-semibold text-gray-800 dark:text-gray-500">
                            Statistik Jumlah Mahasiswa
                        </div>
                        {!! $chartCount->container() !!}

                    </div>
                </div>
                <div class="grid gap-4 grid-cols-2 grid-rows-1">
                    <div id = 'mahasiswaChartContainer'
                        class="p-4 flex rounded-lg border-2 border-gray-200 h-96 rounded bg-gray-50 dark:bg-gray-800">
                        <div>
                            <div class=" text-sm font-semibold text-gray-800 dark:text-gray-500">
                                Statistik Mahasiswa PKL
                            </div>
                            {!! $chartPKL->container() !!}
                        </div>
                    </div>
                    <div id = 'mahasiswaChartContainer'
                        class="p-4 flex rounded-lg border-2 border-gray-200 h-96 rounded bg-gray-50 dark:bg-gray-800">
                        <div>
                            <div class=" text-sm font-semibold text-gray-800 dark:text-gray-500">
                                Statistik Mahasiswa Skripsi
                            </div>
                            {!! $chartSkripsi->container() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ $chartCount->cdn() }}"></script>
    {{ $chartCount->script() }}

    <script src="{{ $chartPKL->cdn() }}"></script>
    {{ $chartPKL->script() }}

    <script src="{{ $chartSkripsi->cdn() }}"></script>
    {{ $chartSkripsi->script() }}
@endsection
