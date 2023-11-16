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
                Edit Status Mahasiswa
            </h1>

            <form action="{{ route('operator.editStatus', ['nim' => $mahasiswa->nim]) }}" method="post">
            <div class="form-group">
                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                <input type="text" id="nim" name="nim" value="{{ $mahasiswa->nim }}" aria-label="disabled input"
                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled>
            </div>

            <div class="form-group">
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ Auth::user()->name }}" aria-label="disabled input"
                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled>
            </div>

            <div class="form-group">
                <label for="angkatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Angkatan</label>
                <input type="text" id="angkatan" name="angkatan" value="{{ $mahasiswa->angkatan }}" aria-label="disabled input"
                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled>
            </div>

            <div class="form-group">
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <select id="status" name="status"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="Aktif" {{ $mahasiswa->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Cuti" {{ $mahasiswa->status === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Mangkir" {{ $mahasiswa->status === 'Mangkir' ? 'selected' : '' }}>Mangkir</option>
                    <option value="DO" {{ $mahasiswa->status === 'DO' ? 'selected' : '' }}>DO (Drop Out)</option>
                    <option value="Undur Diri" {{ $mahasiswa->status === 'Undur Diri' ? 'selected' : '' }}>Undur Diri</option>
                    <option value="Lulus" {{ $mahasiswa->status === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="Meninggal Dunia" {{ $mahasiswa->status === 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                </select>
            </div>
            <div class="m-auto">
                <button type="submit" name="submit"
                    class="mr-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Save
                </button>
                <a href="{{ route('operator.viewDaftarMhs') }}"
                    class="mr-auto text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none dark:focus:ring-gray-600">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
@endsection