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
            Daftar Belum Lulus PKL
        </h1>
        <form class="flex items-center" action="{{ route('doswal.filterIRS') }}" method="GET">            
            <div class="relative mt-1">
                <select name="filter" id="filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    <option value="all">Semua Semester</option>    
                     
                </select>
            </div>
            <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Filter
            </button>
        </form>
        <br>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                                Nilai
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Scan PKL
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($pklData as $pkl)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover-bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $pkl->mahasiswa->nama }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $pkl->mahasiswa->nim }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $pkl->mahasiswa->angkatan }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $pkl->nilai }}
                        </td>
                        <td class="px-6 py-4">
                        <a href="{{ asset('storage/' . $pkl->scan_pkl) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Lihat file</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection