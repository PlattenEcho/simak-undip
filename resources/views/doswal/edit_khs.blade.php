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
                class="text-l mb-5 font-semibold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                Edit KHS
            </h1>
            <form enctype="multipart/form-data" class="space-y-4 md:space-y-6" method="POST" autocomplete="on" action="{{ route('khs.update', [$khs->id_khs]) }}" >
            @csrf
            <div class="form-group">
                <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester:</label>
                <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Pilih Semester</option>
                    <option value="{{ $khs->semester }}" selected>{{ $khs->semester }}</option>
                    @foreach ($remainingSemesters as $semester)
                        <option value="{{ $semester }}">{{ $semester }}</option>
                    @endforeach
                </select>
                @error('semester')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="sks_smt" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS Semester:</label>
                <input id="sks_smt" name="sks_smt" value="{{ $khs->sks_smt }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('sks_smt')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="sks_kum" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS Kumulatif:</label>
                <input id="sks_kum" name="sks_kum" value="{{ $khs->sks_kum }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('sks_kum')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="ips" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Semester:</label>
                <input id="ips" name="ips" value="{{ $khs->ips }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('ips')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="ipk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Kumulatif:</label>
                <input id="ipk" name="ipk" value="{{ $khs->ipk }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('ipk')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <!-- <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="scan_irs">Upload Scan KHS (PDF only):</label>
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
            </div> -->
            <div class="m-auto">
                <button type="submit" name="submit"
                    class="mr-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Submit
                </button>
                <a href="{{ route('doswal.viewVerifikasiKHS') }}"
                    class="mr-auto text-white bg-gray-400 hover-bg-gray-500 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-400 dark:hover-bg-gray-500 focus:outline-none dark:focus:ring-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
@endsection