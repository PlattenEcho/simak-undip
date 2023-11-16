@extends('departemen.navsidebar')

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
            Rekap Mahasiswa Berdasarkan Status
        </h1>
        <form class="flex items-center" action="{{ route('departemen.viewRekapStatus') }}" method="GET">            
            <div class="relative mt-1">
                <select name="angkatan" id="angkatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    <option value="" selected disabled>Pilih Angkatan</option>    
                    @foreach ($daftarAngkatan as $angkatan)
                        <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                    @endforeach      
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
                        <tr scope="col" class="px-6 py-3 text-center">
                            <th scope="col" class="px-6 py-3" colspan="7">Status Mahasiswa Angkatan {{ $mhsData[0]->angkatan }}</th>
                        </tr>
                    </thead>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 text-center">
                            <th scope="col" class="px-6 py-3">
                                Aktif
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cuti
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                Mangkir
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Drop Out
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Undur Diri
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Lukus
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Meninggal Dunia
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody>            
                    <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover-bg-gray-600">
                        <td class="px-6 py-4">
                            <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $aktif }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $cuti }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $mangkir }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $do }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $undurDiri }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $lulus }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $md }}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="p-3">        
                    <a href="#" type="button" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cetak PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection