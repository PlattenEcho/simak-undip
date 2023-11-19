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
            Rekap Mahasiswa Perwalian Berdasarkan Status
        </h1>
        <br>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            @foreach ($daftarAngkatan as $angkatan)
                            <th scope="col" class="px-6 py-3">
                                {{ $angkatan }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="col" class="px-6 py-3">
                            Aktif
                        </th>
                        @foreach ($daftarAngkatan as $angkatan)
                        <td class="px-6 py-4">
                            <a href="{{ route('doswal.viewDaftarAktif', [$angkatan, 'Aktif']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $aktif[$angkatan] }}</a>
                        </td>
                        @endforeach
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="col" class="px-6 py-3">
                            Cuti
                        </th>
                        @foreach ($daftarAngkatan as $angkatan)
                        <td class="px-6 py-4">
                            <a href="{{ route('doswal.viewDaftarAktif', [$angkatan, 'Cuti']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $cuti[$angkatan] }}</a>
                        </td>
                        @endforeach
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="col" class="px-6 py-3">
                            Mangkir
                        </th>
                        @foreach ($daftarAngkatan as $angkatan)
                        <td class="px-6 py-4">
                            <a href="{{ route('doswal.viewDaftarAktif', [$angkatan, 'Mangkir']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $mangkir[$angkatan] }}</a>
                        </td>
                        @endforeach
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="col" class="px-6 py-3">
                            Drop Out
                        </th>
                        @foreach ($daftarAngkatan as $angkatan)
                        <td class="px-6 py-4">
                            <a href="{{ route('doswal.viewDaftarAktif', [$angkatan, 'Drop Out']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $do[$angkatan] }}</a>
                        </td>
                        @endforeach
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="col" class="px-6 py-3">
                            Undur Diri
                        </th>
                        @foreach ($daftarAngkatan as $angkatan)
                        <td class="px-6 py-4">
                            <a href="{{ route('doswal.viewDaftarAktif', [$angkatan, 'Undur Diri']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $undurDiri[$angkatan] }}</a>
                        </td>
                        @endforeach
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="col" class="px-6 py-3">
                            Lulus
                        </th>
                        @foreach ($daftarAngkatan as $angkatan)
                        <td class="px-6 py-4">
                            <a href="{{ route('doswal.viewDaftarAktif', [$angkatan, 'Lulus']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $lulus[$angkatan] }}</a>
                        </td>
                        @endforeach
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="col" class="px-6 py-3">
                            Meninggal Dunia
                        </th>
                        @foreach ($daftarAngkatan as $angkatan)
                        <td class="px-6 py-4">
                            <a href="{{ route('doswal.viewDaftarAktif', [$angkatan, 'Meninggal Dunia']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $md[$angkatan] }}</a>
                        </td>
                        @endforeach
                    </tr>
                </table>
                <div class="p-3">        
                    <a href="{{ route('doswal.cetakRekapStatus') }}" type="button" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cetak PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection