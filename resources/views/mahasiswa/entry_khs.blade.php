@extends('mahasiswa.navsidebar')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

            @if (session('success'))
                <div class="p-4 mr-2 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
            <h1
                class="text-l mb-5 font-semibold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                Entry KHS
            </h1>
            <form class="space-y-4 md:space-y-6" method="POST" autocomplete="on" action="{{ route('khs.store') }}" >
            @csrf
            <div class="form-group">
                <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester:</label>
                <input type="hidden" name="semester" value="{{ $semester }}">
                <input type="text" id="semester" name="semester_display" value="{{ $semester }}" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="Disabled input" disabled>
            </div>
            <div class="form-group">
                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM:</label>
                <input type="text" class="form-control" id="nim" name="nim" value="{{ $nim }}" pattern="[0-9]{14}">
                @error('nim')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="sks_smt" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS Semester:</label>
                <input type="text" class="form-control" id="sks_smt" name="sks_smt" value="{{ $sks_smt }}">
                @error('sks_smt')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="sks_kum" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS Kumulatif:</label>
                <input type="text" class="form-control" id="sks_kum" name="sks_kum" value="{{ $sks_kum }}">
                @error('sks_kum')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="ips" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Semester:</label>
                <input type="text" class="form-control" id="ips" name="ips" value="{{ $ips }}">
                @error('ips')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="ipk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Kumulatif:</label>
                <input type="text" class="form-control" id="ipk" name="ipk" value="{{ $ipk }}">
                @error('ipk')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="scan_khs">Upload Scan KHS (PDF only):</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="file_input_help" id="scan_khs" name="scan_khs" type="file" accept="application/pdf">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF (max 5 MB)</p>
                    @error('scan_khs')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <div>
                                {{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>

            <div class="m-auto">
                <button type="submit" name="submit"
                    class="mr-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Submit
                </button>
                <a href="{{ route('khs.viewEntry') }}"
                    class="mr-auto text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none dark:focus:ring-gray-600">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
@endsection