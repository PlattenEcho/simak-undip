@extends('doswal.navsidebar')

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
        <h1
            class="text-2xl mb-5 font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Verifikasi IRS
        </h1>
        <form class="flex items-center" action="{{ route('doswal.filterIRS') }}" method="GET">            
            <div class="relative mt-1">
                <select name="filter" id="filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    <option value="all">Semua Semester</option>    
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester }}">{{ $semester }}</option>
                    @endforeach      
                </select>
            </div>
            <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Filter
            </button>
        </form>
        <br>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if(!$irsData)
            <div class="pb-4 bg-white dark:bg-gray-900">
                <p class="mt-2 ml-2 text-base text-gray-500 dark:text-gray-400">Tidak ada IRS yang perlu diverifikasi</p>
            </div>
            @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                NIM
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Angkatan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Semester
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah SKS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Scan IRS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($irsData as $irs)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover-bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $irs->mahasiswa->nama }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $irs->mahasiswa->nim }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $irs->mahasiswa->angkatan }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $irs->semester }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $irs->jml_sks }}
                        </td>
                        <td class="px-6 py-4">
                        <a href="{{ asset('storage/' . $irs->scan_irs) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Lihat file</a>
                        </td>
                        <td>
                            <form action="{{ route('irs.verifikasi', $irs->id_irs) }}" method="post">
                                @csrf
                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Verifikasi</button>
                            </form> 
                            <form action="{{ route('irs.reject', $irs->id_irs) }}" method="post">
                                @csrf
                                <button type="submit" class="text-white bg-pink-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Reject</button>
                            </form> 
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection