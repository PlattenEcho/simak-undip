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
            <h1 class="text-l mb-5 font-semibold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                Edit Skripsi
            </h1>
            <form enctype="multipart/form-data" method="POST" action="{{ route('skripsi.update', ['id' => $skripsi->id_skripsi]) }}">
                @csrf
                <div class="form-group">
                    <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester:</label>
                    <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option value="">Pilih Semester</option>
                        <option value="{{ $skripsi->semester }}" selected>{{ $skripsi->semester }}</option>
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
                    <label for="nilai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai:</label>
                    <select id="nilai" name="nilai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option value="A" {{ $skripsi->nilai === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $skripsi->nilai === 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ $skripsi->nilai === 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ $skripsi->nilai === 'D' ? 'selected' : '' }}>D</option>
                        <option value="E" {{ $skripsi->nilai === 'E' ? 'selected' : '' }}>E</option>
                    </select>
                    @error('nilai')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <div>
                                {{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="form-group">
                        <label for="lama_studi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama
                            Studi:</label>
                        <input type="text" id="lama_studi" name="lama_studi" value="{{ $skripsi->lama_studi }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @error('lama_studi')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <div>
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_sidang"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                            Sidang</label>
                        <input type="date" name="tanggal_sidang" id="tanggal_sidang"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            value="{{ $skripsi->tanggal_sidang }}">

                        @error('tanggal_sidang')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <div>
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="m-auto">
                    <button type="submit" name="submit"
                        class="mr-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover-bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Submit
                    </button>
                    <a href="{{ route('doswal.viewVerifikasiSkripsi') }}"
                        class="mr-auto text-white bg-gray-400 hover-bg-gray-500 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-400 dark:hover-bg-gray-500 focus:outline-none dark:focus:ring-gray-600">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
