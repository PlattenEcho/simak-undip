@extends('operator.navsidebar')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <h1 class="text-l mb-5 font-semibold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                Upload Data Mahasiswa
            </h1>
            <form action="{{ route('mahasiswa.uploadExcel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="excel_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih File Excel (.xlsx):</label>
                    <input type="file" id="excel_file" name="excel_file" class="border border-gray-300 p-2 rounded-md">
                </div>
                <button type="submit"
                    class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Unggah
                </button>
            </form>
        </div>
    </div>
@endsection
