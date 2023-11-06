@extends('templates.main')

@section('body')
<div class="text-center">
    <h3 class="text-xl mb-5 font-bold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
        Daftar Sudah Lulus PKL Mahasiswa Informatika Fakultas Sains dan Matematika Universitas Diponegoro
    </h3>
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3 border">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 border">
                        NIM
                    </th>
                    <th scope="col" class="px-6 py-3 border">
                        Angkatan
                    </th>
                    <th scope="col" class="px-6 py-3 border">
                        Nilai
                    </th>
                    
                </tr>
            </thead>
            <tbody>
            @foreach ($pklData as $pkl)
            <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover-bg-gray-600">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border">
                    {{ $pkl->mahasiswa->nama }}
                </td>
                <td class="px-6 py-4 border">
                    {{ $pkl->mahasiswa->nim }}
                </td>
                <td class="px-6 py-4 border">
                    {{ $pkl->mahasiswa->angkatan }}
                </td>
                <td class="px-6 py-4 border">
                    {{ $pkl->nilai }}
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
