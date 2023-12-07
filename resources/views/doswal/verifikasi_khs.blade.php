@extends('doswal.navsidebar')
<link
	href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
	rel="stylesheet">
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
            Verifikasi KHS
        </h1>
        <form class="flex items-center" action="{{ route('khs.filter') }}" method="GET">            
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
            @if(!$khsData)
            <div class="pb-4 bg-white dark:bg-gray-900">
                <p class="mt-2 ml-2 text-base text-gray-500 dark:text-gray-400">Tidak ada KHS yang perlu diverifikasi</p>
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
                                Jumlah SKS Semester
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah SKS Kumulatif
                            </th>
                            <th scope="col" class="px-6 py-3">
                                IP Semester
                            </th>
                            <th scope="col" class="px-6 py-3">
                                IP Kumulatif
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Scan KHS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($khsData as $khs)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover-bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $khs->mahasiswa->nama }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $khs->mahasiswa->nim }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $khs->mahasiswa->angkatan }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $khs->semester }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $khs->sks_smt }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $khs->sks_kum }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $khs->ips }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $khs->ipk }}
                        </td>
                        <td class="px-6 py-4">
                        <a href="{{ asset('storage/' . $khs->scan_khs) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Lihat file</a>
                        </td>
                        <td>
                            <a data-popover-target="popover-verif-{{ $khs->id_khs }}" href="#" data-modal-target="verifikasi-modal-{{ $khs->id_khs }}" data-modal-toggle="verifikasi-modal-{{ $khs->id_khs }}" class="text-green-400 hover:text-green-100  mr-2">
								<i class="material-icons-outlined text-base">domain_verification</i>
							</a>        
                            <div data-popover id="popover-verif-{{ $khs->id_khs }}" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2">
                                    <p>Verifikasi</p>
                                </div>
                            </div>
							<a data-popover-target="popover-edit-{{ $khs->id_khs }}" href="{{ route('khs.viewEditKHS', [$khs->id_khs]) }}" class="text-blue-400 hover:text-blue-100 mx-2">
								<i class="material-icons-outlined text-base">edit</i>
							</a>
                            <div data-popover id="popover-edit-{{ $khs->id_khs }}" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2">
                                    <p>Edit</p>
                                </div>
                            </div>
							<a data-popover-target="popover-delete-{{ $khs->id_khs }}" href="#" data-modal-target="delete-modal-{{ $khs->id_khs }}" data-modal-toggle="delete-modal-{{ $khs->id_khs }}" class="text-red-400 hover:text-red-100 ml-2">
								<i class="material-icons-round text-base">delete_outline</i>
							</a>
                            <div data-popover id="popover-delete-{{ $khs->id_khs }}" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2"> 
                                    <p>Delete</p>
                                </div>
                            </div>
                            <div id="verifikasi-modal-{{ $khs->id_khs }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="verifikasi-modal-{{ $khs->id_khs }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda yakin ingin memverifikasi KHS ini?</h3>
                                            <form action="{{ route('khs.verifikasi', [$khs->id_khs]) }}" method="post">
                                                @csrf
                                                <button data-modal-hide="verifikasi-modal-{{ $khs->id_khs }}" type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                                    Ya
                                                </button>
                                                <button data-modal-hide="verifikasi-modal-{{ $khs->id_khs }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="delete-modal-{{ $khs->id_khs }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal-{{ $khs->id_khs }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda yakin ingin menghapus KHS ini?</h3>
                                            <form action="{{ route('khs.delete', [$khs->id_khs]) }}" method="post">
                                                @csrf
                                                <button data-modal-hide="delete-modal-{{ $khs->id_khs }}" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                                    Ya
                                                </button>
                                                <button data-modal-hide="delete-modal-{{ $khs->id_khs }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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