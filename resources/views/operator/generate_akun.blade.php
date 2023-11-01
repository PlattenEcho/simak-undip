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
            Generate Akun Mahasiswa 
        </h1>
        <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br><br>
                <button class="mr-auto text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-400 dark:hover:bg-green-500 focus:outline-none dark:focus:ring-green-600" type="button">Import Data Mahasiswa</button>
        </form>
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
                <form action="{{ route('mahasiswa.generateAccounts') }}" method="POST">
                    @csrf
                    <button type="submit" class="ml-auto text-white bg-pink-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Generate Account</button>
                </form>    
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        NIM
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Angkatan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jalur Masuk
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        NIP Dosen Wali
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($mhsData as $mhs)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover-bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $mhs['nim'] }}
                    </td>  
                    <td class="px-6 py-4">
                        {{ $mhs['nama'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $mhs['angkatan'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $mhs['status'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $mhs['jalur_masuk'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $mhs['nip'] }}
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