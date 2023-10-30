@extends('templates.main')

@section('body')
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div>
                        <div class="flex flex-col items-center mb-6">
                            <a href="#"
                                class="flex items-center mb-2 text-2xl font-semibold text-gray-900 dark:text-white">
                                <img class="w-10 h-10 mr-2"
                                    src="https://seeklogo.com/images/U/universitas-diponegoro-logo-6B2C58478B-seeklogo.com.png"
                                    alt="logo">
                            </a>
                            <a href="" class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
                                SIMAK Undip
                            </a>
                        </div>
                        <h1
                            class="text-l mb-5 font-semibold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                            Sign in to your account
                        </h1>

                        @if (session()->has('loginError'))
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <span class="font-medium">Log-In Gagal!</span>
                                <p>Silakan Coba Kembali.</p>
                            </div>
                        @endif

                        @if (session()->has('success'))
                            <div class="p-4 mr-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                <span class="font-medium">Registrasi Berhasil!</span>
                                <p>Silakan Login Dengan Akun Baru.</p>
                            </div>
                        @endif

                        @if (session()->has('logoutSuccess'))
                            <div class="p-4 mr-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                <span class="font-medium">Log Out Berhasil!</span>
                                <p>Silakan Login Kembali.</p>
                            </div>
                        @endif
                    </div>

                    <form class="space-y-4 md:space-y-6" action="/login" method="POST">
                        @csrf
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                username</label>
                            <input type="text" name="username" id="username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Masukkan Username" required="" value="{{ old('username') }}">
                            @error('username')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Perhatian!</span> {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="Masukkan Password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="">
                            @error('password')
                                <div class="red-alert" role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Perhatian!</span> {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>

                        <div class="m-auto">
                            <button type="submit"
                                class="w-full mr-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Log In
                            </button>
                        </div>

                        <div class="flex flex-col items-center'">
                            <p class="text-center font-medium text-black-600 dark:text-primary-500">
                                Belum memiliki akun? <a href="{{ route('register') }}"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-500 hover:underline dark:text-primary-500">Register</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
