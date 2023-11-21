@extends('mahasiswa.navsidebar')

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
                    @if ($ipkTertinggi)
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


            <div class="flex flex-wrap w-full mt-4 max-w-8xl">
                @foreach ($khs as $khsItem)
                    @if ($khsItem->semester < 4)
                        @if ($khsItem->semester == 3)
                            <div class=" w-auto rounded-lg border-2 border-gray-200 h-40 rounded bg-gray-50 dark:bg-gray-800"
                                style="width: 32.4%;">
                                <div class="mx-4 mt-4 mb-1 text-sm font-semibold text-gray-800 dark:text-gray-500">
                                    Semester {{ $khsItem->semester }}
                                </div>
                                <div class="mx-4 mt-1 text-left text-sm  text-gray-800 dark:text-gray-500">
                                    @if ($khsItem->status == 0)
                                        Status: Unverified
                                    @else
                                        Status: Verified
                                    @endif
                                    <br>
                                    SKS Semester: {{ $khsItem->sks_smt }}
                                    <br>
                                    SKS Kumulatif: {{ $khsItem->sks_kum }}
                                    <br>
                                    IP Semester: {{ $khsItem->ips }}
                                    <br>
                                    IP Kumlulatif: {{ $khsItem->ipk }}
                                    <br>
                                </div>
                            </div>
                        @else
                            <div class=" w-auto rounded-lg border-2 border-gray-200 h-40 rounded bg-gray-50 dark:bg-gray-800 mr-4"
                                style="width: 32.4%;">
                                <div class="mx-4 mt-4 mb-1 text-sm font-semibold text-gray-800 dark:text-gray-500">
                                    Semester {{ $khsItem->semester }}
                                </div>
                                <div class="mx-4 mt-1 text-left text-sm  text-gray-800 dark:text-gray-500">
                                    @if ($khsItem->status == 0)
                                        Status: Unverified
                                    @else
                                        Status: Verified
                                    @endif
                                    <br>
                                    SKS Semester: {{ $khsItem->sks_smt }}
                                    <br>
                                    SKS Kumulatif: {{ $khsItem->sks_kum }}
                                    <br>
                                    IP Semester: {{ $khsItem->ips }}
                                    <br>
                                    IP Kumlulatif: {{ $khsItem->ipk }}
                                    <br>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>

            <div class="flex flex-wrap w-full mt-4 max-w-8xl">
                @foreach ($khs as $khsItem)
                    @if ($khsItem->semester > 3 && $khsItem->semester < 7)
                        @if ($khsItem->semester == 6)
                            <div class=" w-auto rounded-lg border-2 border-gray-200 h-40 rounded bg-gray-50 dark:bg-gray-800"
                                style="width: 32.4%;">
                                <div class="mx-4 mt-4 mb-1 text-sm font-semibold text-gray-800 dark:text-gray-500">
                                    Semester {{ $khsItem->semester }}
                                </div>
                                <div class="mx-4 mt-1 text-left text-sm  text-gray-800 dark:text-gray-500">
                                    @if ($khsItem->status == 0)
                                        Status: Unverified
                                    @else
                                        Status: Verified
                                    @endif
                                    <br>
                                    SKS Semester: {{ $khsItem->sks_smt }}
                                    <br>
                                    SKS Kumulatif: {{ $khsItem->sks_kum }}
                                    <br>
                                    IP Semester: {{ $khsItem->ips }}
                                    <br>
                                    IP Kumlulatif: {{ $khsItem->ipk }}
                                    <br>
                                </div>
                            </div>
                        @else
                            <div class=" w-auto rounded-lg border-2 border-gray-200 h-40 rounded bg-gray-50 dark:bg-gray-800 mr-4"
                                style="width: 32.4%;">
                                <div class="mx-4 mt-4 mb-1 text-sm font-semibold text-gray-800 dark:text-gray-500">
                                    Semester {{ $khsItem->semester }}
                                </div>
                                <div class="mx-4 mt-1 text-left text-sm  text-gray-800 dark:text-gray-500">
                                    @if ($khsItem->status == 0)
                                        Status: Unverified
                                    @else
                                        Status: Verified
                                    @endif
                                    <br>
                                    SKS Semester: {{ $khsItem->sks_smt }}
                                    <br>
                                    SKS Kumulatif: {{ $khsItem->sks_kum }}
                                    <br>
                                    IP Semester: {{ $khsItem->ips }}
                                    <br>
                                    IP Kumlulatif: {{ $khsItem->ipk }}
                                    <br>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>

            <div class="flex flex-wrap w-full mt-4 max-w-8xl">
                @foreach ($khs as $khsItem)
                    @if ($khsItem->semester > 6 && $khsItem->semester < 10)
                        @if ($khsItem->semester == 9)
                            <div class=" w-auto rounded-lg border-2 border-gray-200 h-40 rounded bg-gray-50 dark:bg-gray-800"
                                style="width: 32.4%;">
                                <div class="mx-4 mt-4 mb-1 text-sm font-semibold text-gray-800 dark:text-gray-500">
                                    Semester {{ $khsItem->semester }}
                                </div>
                                <div class="mx-4 mt-1 text-left text-sm  text-gray-800 dark:text-gray-500">
                                    @if ($khsItem->status == 0)
                                        Status: Unverified
                                    @else
                                        Status: Verified
                                    @endif
                                    <br>
                                    SKS Semester: {{ $khsItem->sks_smt }}
                                    <br>
                                    SKS Kumulatif: {{ $khsItem->sks_kum }}
                                    <br>
                                    IP Semester: {{ $khsItem->ips }}
                                    <br>
                                    IP Kumlulatif: {{ $khsItem->ipk }}
                                    <br>
                                </div>
                            </div>
                        @else
                            <div class=" w-auto rounded-lg border-2 border-gray-200 h-40 rounded bg-gray-50 dark:bg-gray-800 mr-4"
                                style="width: 32.4%;">
                                <div class="mx-4 mt-4 mb-1 text-sm font-semibold text-gray-800 dark:text-gray-500">
                                    Semester {{ $khsItem->semester }}
                                </div>
                                <div class="mx-4 mt-1 text-left text-sm  text-gray-800 dark:text-gray-500">
                                    @if ($khsItem->status == 0)
                                        Status: Unverified
                                    @else
                                        Status: Verified
                                    @endif
                                    <br>
                                    SKS Semester: {{ $khsItem->sks_smt }}
                                    <br>
                                    SKS Kumulatif: {{ $khsItem->sks_kum }}
                                    <br>
                                    IP Semester: {{ $khsItem->ips }}
                                    <br>
                                    IP Kumlulatif: {{ $khsItem->ipk }}
                                    <br>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>

            </section>
        @endsection
