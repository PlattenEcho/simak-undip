@extends('operator.navsidebar')

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
            Rekap Skripsi
        </h1>
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <form class="flex items-center" action="{{ route('operator.viewRekapSkripsi') }}" method="GET">            
                <div class="relative mt-1">
                    <select name="tahun1" id="tahun1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option value="" selected disabled>Pilih Tahun</option>    
                        @foreach ($daftarAngkatan as $angkatan)
                            <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                        @endforeach      
                    </select>
                </div>
                <div class="pb-4 bg-white dark:bg-gray-900">
                    <p class="mt-2 ml-2 text-base text-gray-500 dark:text-gray-400">- </p>
                </div>
                <div class="relative ml-1 mt-1">
                    <select name="tahun2" id="tahun2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option value="" selected disabled>Pilih Tahun</option>    
                        @foreach ($daftarAngkatan as $angkatan)
                            <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                        @endforeach   
                    </select>
                </div>
                <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Filter
                </button>
            </form>
            <div class="p-3">        
                <a href="{{ route('operator.cetakRekapSkripsi', [$tahun1, $tahun2]) }}" type="button" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cetak PDF</a>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if(!$skripsiData)
            <div class="pb-4 bg-white dark:bg-gray-900">
                <p class="mt-2 ml-2 text-base text-gray-500 dark:text-gray-400">Tidak ada data skripsi</p>
            </div>
            @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr scope="col" class="px-6 py-3 text-center">
                            <th scope="col" class="px-6 py-3" colspan="10">Angkatan</th>
                        </tr>
                    </thead>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 text-center">
                            @for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++)
                            <th scope="col" class="px-6 py-3" colspan="2">
                                {{ $tahun }}
                            </th>
                            @endfor
                        </tr>
                    </thead>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 text-center">
                            @for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++)
                            <th scope="col" class="px-6 py-3">
                                Sudah
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Belum
                            </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>            
                    <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover-bg-gray-600">
                        @for ($tahun = $tahun1; $tahun <= $tahun2; $tahun++)
                        <td class="px-6 py-4">
                            <a href="{{ route('operator.viewSudahSkripsi', $tahun) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $sudahSkripsi[$tahun] }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('operator.viewBelumSkripsi', $tahun) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $belumSkripsi[$tahun] }}</a>
                        </td>
                        @endfor
                    </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection