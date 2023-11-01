@extends('operator.navsidebar')

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
            <br>
            <h1
                class="text-l mb-5 font-semibold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                Entry Data Mahasiswa
            </h1>
            <a href="{{ route('operator.dashboard') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-2">
                Kembali
            </a> <br>
            <a href="{{ route('mahasiswa.uploadExcelForm') }}" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Upload File Excel
            </a>
            <form class="space-y-4 md:space-y-6" method="POST" autocomplete="on" action="{{ route('mahasiswa.store') }}" >
            @csrf
            <div class="form-group">
                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM:</label>
                <input type="text" id="nim" name="nim" value="{{ old('nim') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('nim')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama:</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('nama')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="angkatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Angkatan:</label>
                <input type="text" id="angkatan" name="angkatan" value="{{ old('angkatan') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('angkatan')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <!-- <div class="form-group">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('email')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div> -->
            <div class="form-group">
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status:</label>
                <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Dropout" {{ old('status') == 'Dropout' ? 'selected' : '' }}>Dropout</option>
                </select>
                @error('status')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jalur_masuk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jalur Masuk:</label>
                <select id="jalur_masuk" name="jalur_masuk" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" selected>Pilih Jalur Masuk</option>
                    <option value="SBUB" {{ old('jalur_masuk') == 'SBUB' ? 'selected' : '' }}>SBUB</option>
                    <option value="SNMPTN" {{ old('jalur_masuk') == 'SNMPTN' ? 'selected' : '' }}>SNMPTN</option>
                    <option value="SBMPTN" {{ old('jalur_masuk') == 'SBMPTN' ? 'selected' : '' }}>SBMPTN</option>
                    <option value="Mandiri" {{ old('jalur_masuk') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                </select>
                @error('jalur_masuk')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="doswal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dosen Wali:</label>
                <select id="doswal" name="doswal" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Pilih Dosen Wali</option>
                    @foreach($dosen_wali as $dosen)
                        <option value="{{ $dosen->nip }}" {{ old('doswal') == $dosen->nip ? 'selected' : '' }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('doswal')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="m-auto">
                <button type="submit" name="submit" value="generate"
                    class="mr-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Generate Account
                </button>
                <a href="{{ route('mahasiswa.showEntry') }}"
                    class="mr-auto text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none dark:focus:ring-gray-600">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
@endsection